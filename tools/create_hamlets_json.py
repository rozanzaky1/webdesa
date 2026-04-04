import json
from pathlib import Path
from datetime import datetime

# Path ke file hamlets.json
HAMLETS_FILE = Path(r"c:\laragon\www\webdesa\storage\hamlets.json")

# Data hamlets dari residents (dari Excel yang sudah diimport)
# Ini adalah contoh - kita akan extractnya dari residents data
hamlets_data = [
    {"id": 1, "name": "Badran Sari"},
    {"id": 2, "name": "Kembang Sari"},
    {"id": 3, "name": "Tanjung Sari"},
    {"id": 4, "name": "Mandala Sari"},
    {"id": 5, "name": "Karya Sari"},
]

# Buat folder storage kalau belum ada
HAMLETS_FILE.parent.mkdir(parents=True, exist_ok=True)

# Write ke JSON file
with HAMLETS_FILE.open('w', encoding='utf-8') as f:
    json.dump(hamlets_data, f, ensure_ascii=False, indent=2)

print(f"✅ Hamlets file created: {HAMLETS_FILE}")
print(f"Total hamlets: {len(hamlets_data)}")
print(f"\nHamlets list:")
for h in hamlets_data:
    print(f"  - {h['name']}")
