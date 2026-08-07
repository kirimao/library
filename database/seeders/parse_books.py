import zipfile
import xml.etree.ElementTree as ET
import os
import json

def parse_books():
    base_dir = os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
    file_path = os.path.join(base_dir, 'public', 'dataset', 'data buku perpus.xlsx')
    out_json = os.path.join(base_dir, 'database', 'seeders', 'books_dataset.json')
    
    books = []
    
    if not os.path.exists(file_path):
        print(f"Error: {file_path} not found.")
        return

    with zipfile.ZipFile(file_path) as z:
        shared_strings = []
        if 'xl/sharedStrings.xml' in z.namelist():
            tree = ET.fromstring(z.read('xl/sharedStrings.xml'))
            for si in tree.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}si'):
                text = ''.join([t.text for t in si.findall('.//{http://schemas.openxmlformats.org/spreadsheetml/2006/main}t') if t.text])
                shared_strings.append(text)
        
        stree = ET.fromstring(z.read('xl/worksheets/sheet1.xml'))
        rows = stree.findall('{http://schemas.openxmlformats.org/spreadsheetml/2006/main}sheetData/{http://schemas.openxmlformats.org/spreadsheetml/2006/main}row')
        
        category_map = {
            'Reading2': 'Reading 2',
            'BIlingual': 'Bilingual',
            'Comoc Islami': 'Comic Islami',
            'komik': 'Comic',
        }
        
        for row in rows:
            r_idx = int(row.attrib.get('r'))
            if r_idx == 1:
                continue # header
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
            
            title = row_data.get('A', '')
            author = row_data.get('B', '')
            publisher = row_data.get('C', '')
            category = row_data.get('D', '')
            
            if category in category_map:
                category = category_map[category]
                
            if not category:
                category = 'Lainnya'
                
            if title and title.lower() != 'title':
                books.append({
                    'title': title,
                    'author': author if author else 'Anonim',
                    'publisher': publisher if publisher else 'Tidak Diketahui',
                    'category': category
                })

    with open(out_json, 'w', encoding='utf-8') as f:
        json.dump(books, f, ensure_ascii=False, indent=2)
        
    print(f"Exported {len(books)} books to {out_json}")

if __name__ == '__main__':
    parse_books()
