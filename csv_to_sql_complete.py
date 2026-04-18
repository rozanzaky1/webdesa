#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
CSV to SQL - Dengan Family dan Hamlet Relations
Extract unique families dan hamlets dari Badransari_Export.csv
"""

import csv
from collections import OrderedDict
from pathlib import Path

def extract_unique_data(csv_file):
    """Extract unique families dan hamlets"""
    
    families = OrderedDict()  # kk -> info keluarga
    hamlets = OrderedDict()   # hamlet -> info dusun
    residents_data = []
    
    delimiter = detect_delimiter(csv_file)
    
    with open(csv_file, 'r', encoding='utf-8-sig', errors='replace') as f:
        reader = csv.DictReader(f, delimiter=delimiter)
        
        for row in reader:
            # Bersihkan kolom
            row = {k.strip(): (v.strip() if v else '') for k, v in row.items()}
            
            # Extract info keluarga
            kk = row.get('family_card_number', '').strip()
            nik = row.get('nik', '').strip()
            name = row.get('name', '').strip()
            
            # Extract info hamlet/dusun
            hamlet = row.get('hamlet', '').strip()
            rt = row.get('rt', '').strip()
            rw = row.get('rw', '').strip()
            
            # Store unique families (using KK as key)
            if kk and kk not in families:
                families[kk] = {
                    'kk': kk,
                    'head_name': name,
                    'head_nik': nik,
                    'hamlet': hamlet,
                    'rt': int(rt) if rt.isdigit() else 0,
                    'rw': int(rw) if rw.isdigit() else 0,
                }
            
            # Store unique hamlets
            if hamlet and hamlet not in hamlets:
                hamlets[hamlet] = {
                    'name': hamlet,
                    'rt': int(rt) if rt.isdigit() else 0,
                    'rw': int(rw) if rw.isdigit() else 0,
                }
            
            # Store resident data
            if nik:
                residents_data.append(row)
    
    return families, hamlets, residents_data

def detect_delimiter(file_path):
    """Deteksi delimiter CSV"""
    with open(file_path, 'r', encoding='utf-8-sig') as f:
        sample = f.read(1024)
    return ';' if sample.count(';') > sample.count(',') else ','

def generate_sql(families, hamlets, residents_data, output_file):
    """Generate SQL lengkap dengan family dan hamlet"""
    
    with open(output_file, 'w', encoding='utf-8') as f:
        # Header
        f.write("-- ===================================\n")
        f.write("-- SQL Import - Badransari Complete\n")
        f.write("-- Include: Hamlets, Families, Residents\n")
        f.write("-- Generated: 2026-04-05\n")
        f.write("-- ===================================\n\n")
        f.write("SET NAMES utf8mb4;\n")
        f.write("SET CHARACTER SET utf8mb4;\n")
        f.write("SET FOREIGN_KEY_CHECKS=0;\n\n")
        
        # ========== HAMLETS (DUSUN) ==========
        f.write("-- ===== INSERT HAMLETS (DUSUN) =====\n")
        f.write(f"-- Total: {len(hamlets)} unique hamlets\n")
        f.write("TRUNCATE TABLE `hamlets`;\n\n")
        
        for hamlet_name, hamlet_data in hamlets.items():
            if hamlet_name:
                hamlet_escaped = hamlet_name.replace("'", "''")
                f.write(f"INSERT INTO `hamlets` (`name`, `rt`, `rw`, `created_at`, `updated_at`) VALUES ")
                f.write(f"('{hamlet_escaped}', {hamlet_data['rt']}, {hamlet_data['rw']}, NOW(), NOW());\n")
        
        f.write("\n")
        
        # ========== FAMILIES (KELUARGA) ==========
        f.write("-- ===== INSERT FAMILIES (KELUARGA) =====\n")
        f.write(f"-- Total: {len(families)} unique families\n")
        f.write("TRUNCATE TABLE `families`;\n\n")
        
        for kk, family_data in families.items():
            if kk:
                hamlet = family_data['hamlet'].replace("'", "''")
                head_name = family_data['head_name'].replace("'", "''")
                head_nik = family_data['head_nik']
                rt = family_data['rt']
                rw = family_data['rw']
                
                f.write(f"INSERT INTO `families` (`kk`, `head_name`, `head_nik`, `hamlet`, `rt`, `rw`, `created_at`, `updated_at`) VALUES ")
                f.write(f"('{kk}', '{head_name}', '{head_nik}', '{hamlet}', {rt}, {rw}, NOW(), NOW());\n")
        
        f.write("\n")
        
        # ========== RESIDENTS ==========
        f.write("-- ===== INSERT RESIDENTS =====\n")
        f.write(f"-- Total: {len(residents_data)} residents\n")
        f.write("TRUNCATE TABLE `residents`;\n\n")
        
        for resident in residents_data:
            nik = resident.get('nik', '').strip()
            name = resident.get('name', '').replace("'", "''")
            gender = resident.get('gender', 'Male').strip()
            birth_place = resident.get('birth_place', '').replace("'", "''")
            birth_date = resident.get('birth_date', '').strip()
            address = resident.get('address', '').replace("'", "''")
            hamlet = resident.get('hamlet', '').strip()
            rt = resident.get('rt', '0').strip()
            rw = resident.get('rw', '0').strip()
            religion = resident.get('religion', 'Islam').strip()
            marital_status = resident.get('marital_status', '').replace("'", "''")
            occupation = resident.get('occupation', '').replace("'", "''")
            phone = resident.get('phone', '').strip()
            status = resident.get('status', 'active').strip()
            
            if nik:
                rt = int(rt) if rt.isdigit() else 0
                rw = int(rw) if rw.isdigit() else 0
                
                f.write(f"INSERT INTO `residents` (")
                f.write(f"`nik`, `name`, `gender`, `birth_place`, `birth_date`, `address`, `hamlet`, `rt`, `rw`, ")
                f.write(f"`religion`, `marital_status`, `occupation`, `phone`, `status`, `created_at`, `updated_at`) VALUES (")
                f.write(f"'{nik}', '{name}', '{gender}', '{birth_place}', '{birth_date}', '{address}', '{hamlet}', {rt}, {rw}, ")
                f.write(f"'{religion}', '{marital_status}', '{occupation}', '{phone}', '{status}', NOW(), NOW());\n")
        
        f.write("\n")
        f.write("SET FOREIGN_KEY_CHECKS=1;\n\n")
        f.write(f"-- ===== SUMMARY =====\n")
        f.write(f"-- Hamlets: {len(hamlets)}\n")
        f.write(f"-- Families: {len(families)}\n")
        f.write(f"-- Residents: {len(residents_data)}\n")
        f.write(f"-- ===== END =====\n")

def main():
    """Main function"""
    
    csv_file = "database/seeders/Badransari_Export.csv"
    output_file = "database/sql/Badransari_Complete.sql"
    
    print("🚀 CONVERTER CSV ke SQL - With Family & Hamlet Relations\n")
    
    if not Path(csv_file).exists():
        print(f"❌ File tidak ditemukan: {csv_file}")
        return
    
    print(f"📂 Processing file: {csv_file}")
    
    families, hamlets, residents_data = extract_unique_data(csv_file)
    
    print(f"\n✅ Data extracted:")
    print(f"   📍 Unique Hamlets: {len(hamlets)}")
    print(f"   👨‍👩‍👧‍👦 Unique Families: {len(families)}")
    print(f"   👤 Total Residents: {len(residents_data)}")
    
    generate_sql(families, hamlets, residents_data, output_file)
    
    print(f"\n💾 Output file: {output_file}")
    print("\n✅ SQL generation complete!\n")
    
    print("📌 NEXT STEPS:")
    print("="*50)
    print("1. Buka PhpMyAdmin Domainesia")
    print("2. Pilih database 'badransa_webdesa'")
    print("3. Klik tab 'Import'")
    print("4. Upload: database/sql/Badransari_Complete.sql")
    print("5. Klik 'Go'")
    print("="*50)

if __name__ == '__main__':
    main()
