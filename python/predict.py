import joblib, sys

model = joblib.load("model.pkl")

if len(sys.argv) < 4:
    print("Usage: python predict.py <lama_bekerja> <kehadiran> <produktivitas_kerja>")
    exit()

lama = float(sys.argv[1])
hadir = float(sys.argv[2])
prod = 1 if sys.argv[3].upper() == "TERCAPAI" else 0

pred = model.predict([[lama, hadir, prod]])
print("Hasil Prediksi:", pred[0])