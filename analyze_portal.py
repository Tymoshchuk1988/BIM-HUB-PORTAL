import os
import json
from datetime import datetime
from pathlib import Path

def analyze_directory(root_path, exclude_dirs=None, max_depth=None):
    """
    Аналізує структуру директорії та повертає словник з інформацією
    
    Args:
        root_path: Шлях до кореневої директорії
        exclude_dirs: Список директорій для виключення
        max_depth: Максимальна глибина сканування
    """
    if exclude_dirs is None:
        exclude_dirs = []
    
    analysis = {
        'root_path': str(root_path),
        'scan_date': datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
        'total_size_bytes': 0,
        'total_files': 0,
        'total_dirs': 0,
        'file_types': {},
        'structure': {},
        'largest_files': []
    }
    
    def scan_directory(current_path, depth=0):
        """Рекурсивна функція для сканування директорії"""
        dir_info = {
            'name': current_path.name,
            'path': str(current_path),
            'type': 'directory',
            'size': 0,
            'file_count': 0,
            'dir_count': 0,
            'contents': {}
        }
        
        try:
            items = list(current_path.iterdir())
        except PermissionError:
            return dir_info
        except Exception as e:
            print(f"Помилка доступу до {current_path}: {e}")
            return dir_info
        
        for item in items:
            # Перевірка на виключені директорії
            if any(excluded.lower() in str(item).lower() for excluded in exclude_dirs):
                continue
            
            try:
                if item.is_file():
                    # Аналіз файлу
                    file_size = item.stat().st_size
                    file_ext = item.suffix.lower()
                    
                    # Оновлення загальної статистики
                    analysis['total_files'] += 1
                    analysis['total_size_bytes'] += file_size
                    
                    # Статистика по типах файлів
                    if file_ext:
                        analysis['file_types'][file_ext] = analysis['file_types'].get(file_ext, 0) + 1
                    else:
                        analysis['file_types']['no_extension'] = analysis['file_types'].get('no_extension', 0) + 1
                    
                    # Додавання великих файлів до списку
                    analysis['largest_files'].append({
                        'path': str(item),
                        'size': file_size,
                        'size_mb': round(file_size / (1024 * 1024), 2)
                    })
                    
                    # Оновлення інформації про директорію
                    dir_info['file_count'] += 1
                    dir_info['size'] += file_size
                    dir_info['contents'][item.name] = {
                        'name': item.name,
                        'path': str(item),
                        'type': 'file',
                        'size': file_size,
                        'size_mb': round(file_size / (1024 * 1024), 2),
                        'extension': file_ext if file_ext else 'none'
                    }
                    
                elif item.is_dir():
                    # Рекурсивний аналіз піддиректорії
                    if max_depth is None or depth < max_depth:
                        subdir_info = scan_directory(item, depth + 1)
                        dir_info['dir_count'] += 1
                        dir_info['size'] += subdir_info['size']
                        dir_info['contents'][item.name] = subdir_info
                        analysis['total_dirs'] += 1
                        
            except Exception as e:
                print(f"Помилка при обробці {item}: {e}")
                continue
        
        return dir_info
    
    # Запуск сканування
    analysis['structure'] = scan_directory(Path(root_path))
    
    # Сортування найбільших файлів
    analysis['largest_files'].sort(key=lambda x: x['size'], reverse=True)
    analysis['largest_files'] = analysis['largest_files'][:20]  # Тільки топ-20
    
    # Додаткові обчислення
    analysis['total_size_mb'] = round(analysis['total_size_bytes'] / (1024 * 1024), 2)
    analysis['total_size_gb'] = round(analysis['total_size_bytes'] / (1024 * 1024 * 1024), 2)
    
    return analysis

def save_report(analysis, output_path):
    """
    Зберігає звіт у текстовому форматі
    
    Args:
        analysis: Словник з результатами аналізу
        output_path: Шлях для збереження звіту
    """
    report_lines = []
    
    # Заголовок
    report_lines.append("=" * 80)
    report_lines.append("АНАЛІЗ СТРУКТУРИ ПАПОК ТА ФАЙЛІВ")
    report_lines.append("=" * 80)
    report_lines.append(f"Коренева директорія: {analysis['root_path']}")
    report_lines.append(f"Дата сканування: {analysis['scan_date']}")
    report_lines.append(f"Загальний розмір: {analysis['total_size_gb']} GB ({analysis['total_size_mb']} MB)")
    report_lines.append(f"Загальна кількість файлів: {analysis['total_files']}")
    report_lines.append(f"Загальна кількість папок: {analysis['total_dirs']}")
    report_lines.append("")
    
    # Статистика по типах файлів
    report_lines.append("-" * 80)
    report_lines.append("СТАТИСТИКА ПО ТИПАХ ФАЙЛІВ:")
    report_lines.append("-" * 80)
    
    # Сортування типів файлів за кількістю
    sorted_file_types = sorted(analysis['file_types'].items(), key=lambda x: x[1], reverse=True)
    
    for file_type, count in sorted_file_types:
        percentage = (count / analysis['total_files']) * 100 if analysis['total_files'] > 0 else 0
        report_lines.append(f"{file_type:20} {count:6} файлів ({percentage:5.1f}%)")
    
    report_lines.append("")
    
    # Топ-20 найбільших файлів
    report_lines.append("-" * 80)
    report_lines.append("ТОП-20 НАЙБІЛЬШИХ ФАЙЛІВ:")
    report_lines.append("-" * 80)
    
    for i, file_info in enumerate(analysis['largest_files'], 1):
        report_lines.append(f"{i:2}. {file_info['size_mb']:8.1f} MB - {file_info['path']}")
    
    report_lines.append("")
    
    # Детальна структура
    report_lines.append("-" * 80)
    report_lines.append("ДЕТАЛЬНА СТРУКТУРА КАТАЛОГІВ:")
    report_lines.append("-" * 80)
    
    def print_structure(structure, indent=0, lines=None):
        """Рекурсивне додавання структури до звіту"""
        prefix = "  " * indent
        
        # Додаємо поточну директорію
        lines.append(f"{prefix}[DIR] {structure['name']}/ (розмір: {round(structure['size']/(1024*1024), 2)} MB, "
                    f"файлів: {structure['file_count']}, папок: {structure['dir_count']})")
        
        # Додаємо вміст
        for name, item in structure['contents'].items():
            if item['type'] == 'file':
                lines.append(f"{prefix}  {name} ({item['size_mb']} MB)")
            elif item['type'] == 'directory':
                print_structure(item, indent + 1, lines)
    
    print_structure(analysis['structure'], 0, report_lines)
    
    # Збереження у файл
    report_content = "\n".join(report_lines)
    
    with open(output_path, 'w', encoding='utf-8') as f:
        f.write(report_content)
    
    print(f"Звіт збережено у: {output_path}")
    
    # Також збережемо JSON для подальшого аналізу
    json_path = output_path.replace('.txt', '.json')
    with open(json_path, 'w', encoding='utf-8') as f:
        json.dump(analysis, f, indent=2, ensure_ascii=False)
    
    print(f"JSON звіт збережено у: {json_path}")

def main():
    # Налаштування шляхів
    portal_path = "/Users/irynashevchuk/Documents/Тимощук/BIMHub/PORTAL"
    exclude_dirs = ["node_modules"]
    report_path = os.path.join(portal_path, "portal_structure_analysis.txt")
    
    print("Початок аналізу структури порталу...")
    print(f"Шлях для аналізу: {portal_path}")
    print(f"Виключаємо папку: {exclude_dirs}")
    print("Це може зайняти деякий час...\n")
    
    try:
        # Аналіз директорії
        analysis = analyze_directory(
            root_path=portal_path,
            exclude_dirs=exclude_dirs,
            max_depth=None  # Без обмеження глибини
        )
        
        # Збереження звіту
        save_report(analysis, report_path)
        
        # Виведення основних результатів у консоль
        print("\n" + "=" * 60)
        print("ОСНОВНІ РЕЗУЛЬТАТИ:")
        print("=" * 60)
        print(f"Загальний розмір: {analysis['total_size_gb']} GB")
        print(f"Загальна кількість файлів: {analysis['total_files']}")
        print(f"Загальна кількість папок: {analysis['total_dirs']}")
        
        # Топ-5 типів файлів
        print("\nТоп-5 типів файлів:")
        sorted_types = sorted(analysis['file_types'].items(), key=lambda x: x[1], reverse=True)[:5]
        for file_type, count in sorted_types:
            percentage = (count / analysis['total_files']) * 100 if analysis['total_files'] > 0 else 0
            print(f"  {file_type}: {count} файлів ({percentage:.1f}%)")
        
        print(f"\nАналіз завершено. Детальний звіт доступний у: {report_path}")
        
    except Exception as e:
        print(f"Помилка під час аналізу: {e}")

if __name__ == "__main__":
    main()