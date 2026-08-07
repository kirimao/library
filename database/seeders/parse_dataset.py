import zipfile
import xml.etree.ElementTree as ET
import os
import json
import sys

def parse_dataset():
    records = []
    
    base_dir = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
    sd_path = os.path.join(base_dir, 'public', 'dataset', 'PJOK SD SEMESTER GENAP 2025-2026.xlsx')
    smp_path = os.path.join(base_dir, 'public', 'dataset', 'PESERTA DIDIK BARU T.A 2026-2027 SMP PEDULI ANAK - Copy.xlsx')
    
    # 1. SD
    if os.path.exists(sd_path):
        with zipfile.ZipFile(sd_path) as z:
            shared_strings = []
            if 'xl/sharedStrings.xml' in z.namelist():
                tree = ET.fromstring(z.read('xl/sharedStrings.xml'))
                for si in tree.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}si'):
                    text = ''.join([t.text for t in si.findall('.//{http://schemas.openxmlformats.org/spreadsheetml/2006/main}t') if t.text])
                    shared_strings.append(text)
            
            wb_tree = ET.fromstring(z.read('xl/workbook.xml'))
            sheets = wb_tree.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}sheets/{http://schemas.openxmlformats.org/spreadsheetml/2006/main}sheet')
            rels_tree = ET.fromstring(z.read('xl/_rels/workbook.xml.rels'))
            rel_map = {r.attrib['Id']: 'xl/' + os.path.normpath(r.attrib['Target']).replace('\\', '/') for r in rels_tree.findall('{http://schemas.openxmlformats.org/package/2006/relationships}Relationship')}
            
            for s in sheets:
                s_name = s.attrib['name']
                if s_name not in ["PJOK 1.", "PJOK 2.", "PJOK 3.", "PJOK 4.", "PJOK 5."]:
                    continue
                    
                orig_grade = int(s_name.replace("PJOK ", "").replace(".", "").strip())
                new_grade = orig_grade + 1
                grade_name = f"Kelas {new_grade}"
                
                r_id = s.attrib['{http://schemas.openxmlformats.org/officeDocument/2006/relationships}id']
                s_file = rel_map.get(r_id)
                if not s_file or s_file not in z.namelist():
                    continue
                
                stree = ET.fromstring(z.read(s_file))
                rows = stree.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}sheetData/{http://schemas.openxmlformats.org/spreadsheetml/2006/main}row')
                
                for row in rows:
                    cells = row.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}c')
                    row_data = {}
                    for c in cells:
                        ref = c.attrib.get('r')
                        col = ''.join([ch for ch in ref if ch.isalpha()])
                        t = c.attrib.get('t')
                        v = c.find('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}v')
                        v_txt = v.text if v is not None else ''
                        if t == 's' and v_txt.isdigit():
                            v_txt = shared_strings[int(v_txt)] if int(v_txt) < len(shared_strings) else v_txt
                        row_data[col] = v_txt.strip()
                    
                    no_urut = row_data.get('A', '')
                    nis = row_data.get('B', '')
                    nama = row_data.get('C', '')
                    
                    if no_urut.isdigit() and nama and nama not in ["0", "FORMATIF", "SUMATIF"]:
                        records.append({
                            'name': nama,
                            'nis': nis,
                            'member_type': 'SD',
                            'grade': grade_name
                        })

    # 2. SMP
    if os.path.exists(smp_path):
        with zipfile.ZipFile(smp_path) as z:
            shared_strings = []
            if 'xl/sharedStrings.xml' in z.namelist():
                tree = ET.fromstring(z.read('xl/sharedStrings.xml'))
                for si in tree.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}si'):
                    text = ''.join([t.text for t in si.findall('.//{http://schemas.openxmlformats.org/spreadsheetml/2006/main}t') if t.text])
                    shared_strings.append(text)
            
            wb_tree = ET.fromstring(z.read('xl/workbook.xml'))
            sheets = wb_tree.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}sheets/{http://schemas.openxmlformats.org/spreadsheetml/2006/main}sheet')
            rels_tree = ET.fromstring(z.read('xl/_rels/workbook.xml.rels'))
            rel_map = {r.attrib['Id']: 'xl/' + os.path.normpath(r.attrib['Target']).replace('\\', '/') for r in rels_tree.findall('{http://schemas.openxmlformats.org/package/2006/relationships}Relationship')}
            
            for s in sheets:
                s_name = s.attrib['name']
                if s_name not in ["KELAS 7", "KELAS 8", "KELAS 9"]:
                    continue
                    
                grade_name = s_name.replace("KELAS ", "Kelas ")
                r_id = s.attrib['{http://schemas.openxmlformats.org/officeDocument/2006/relationships}id']
                s_file = rel_map.get(r_id)
                if not s_file or s_file not in z.namelist():
                    continue
                
                stree = ET.fromstring(z.read(s_file))
                rows = stree.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}sheetData/{http://schemas.openxmlformats.org/spreadsheetml/2006/main}row')
                
                for row in rows:
                    cells = row.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}c')
                    row_data = {}
                    for c in cells:
                        ref = c.attrib.get('r')
                        col = ''.join([ch for ch in ref if ch.isalpha()])
                        t = c.attrib.get('t')
                        v = c.find('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}v')
                        v_txt = v.text if v is not None else ''
                        if t == 's' and v_txt.isdigit():
                            v_txt = shared_strings[int(v_txt)] if int(v_txt) < len(shared_strings) else v_txt
                        row_data[col] = v_txt.strip()
                    
                    no_urut = row_data.get('A', '')
                    nama = row_data.get('B', '')
                    nis = row_data.get('C', '') if s_name == "KELAS 7" else row_data.get('D', '')
                    
                    if no_urut.isdigit() and nama and not nama.startswith("Jumlah") and not nama.startswith("Anak") and nama != "SISWA SUMBAWA":
                        records.append({
                            'name': nama,
                            'nis': nis,
                            'member_type': 'SMP',
                            'grade': grade_name
                        })

    print(json.dumps(records, ensure_ascii=False, indent=2))

if __name__ == '__main__':
    parse_dataset()
