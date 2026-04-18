#!/usr/bin/env python3
import csv
import os

csv_path = 'database/seeders/Badransari_Export.csv'

print(f"File exists: {os.path.exists(csv_path)}")
print(f"File size: {os.path.getsize(csv_path)} bytes")

with open(csv_path, 'r', encoding='utf-8') as f:
    reader = csv.DictReader(f)
    rows = list(reader)
    
    print(f'\nTotal rows: {len(rows)}')
    if rows:
        print(f'Columns: {list(rows[0].keys())}')
        print(f'\nFirst row:')
        for key in list(rows[0].keys())[:5]:
            val = rows[0].get(key, 'NONE')
            print(f'  {key}: {val}')
        
        # Test nilai
        print(f'\nColumn test:')
        print(f"  family_card_number = '{rows[0].get('family_card_number', 'NOT FOUND')}'")
        print(f"  nik = '{rows[0].get('nik', 'NOT FOUND')}'")
