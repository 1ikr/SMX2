import time

def infinite_loop():
    while True:
        print("Este es un bucle infinito.")
        time.sleep(1)

if __name__ == "__main__":
    process = infinite_loop

    while True:
        time.sleep(1)

	print("segundo plano")
