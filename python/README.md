# Machine Learning - Python Integration

Folder ini berisi script training & prediksi model kinerja karyawan menggunakan
Decision Tree Classifier (Scikit-Learn). Model dilatih dari dataset `training/data.json`,
kemudian hasilnya disimpan sebagai `model.pkl` dan diintegrasikan dengan sistem Laravel.

File:

| File         | Fungsi |
|-------------|-----------------------------|
| train.py    | Melatih model menggunakan scikit-learn |
| predict.py  | Melakukan prediksi single input |
| model.pkl   | Hasil kompilasi & training model |

Python version: 3.10  
Requirements: pandas, scikit-learn, joblib