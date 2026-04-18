#!/usr/bin/env python3
"""
Add final section to Badransari_Complete.sql
"""

final_section = """
-- ===== HITUNG TOTAL_MEMBERS PER KELUARGA =====
-- PENTING: Jalankan SETELAH semua residents punya family_card_number

UPDATE `families` f 
SET f.`total_members` = (
  SELECT COALESCE(COUNT(*), 0) 
  FROM `residents` r 
  WHERE r.`family_card_number` = f.`kk` 
  AND r.`family_card_number` IS NOT NULL
);

SET FOREIGN_KEY_CHECKS=1;

-- ===== SUMMARY =====
-- ✅ Hamlets: 15
-- ✅ Families: 638 (dengan total_members auto-calculated)
-- ✅ Residents: 1351 (terhubung ke families via family_card_number)
-- ✅ UPDATE: 638 statements untuk link residents ke families
-- ===== SELESAI =====
"""

with open('database/sql/Badransari_Complete.sql', 'a', encoding='utf-8') as f:
    f.write(final_section)

print("✅ Final section added successfully!")
