import random

class TratamientoFichero:
    def __init__(self, nombre_fichero):
        self.nombre_fichero = nombre_fichero

    def write_file(self, line_to_write):
        with open(self.nombre_fichero, "a") as f:
            f.write(line_to_write + "\n")

    def read_file(self):
        with open(self.nombre_fichero, "r") as f:
            print(f.read())

class Juego:
    def __init__(self):
        self.iniciar_juego()

    def iniciar_juego(self):
        self.numero_secreto = random.randint(1, 10)
        self.intentos = 0

    def jugar(self):
        print("Adivina un número del 1 al 10.")
        while True:
            try:
                intento = int(input("Ingresa un numero del 1 al 10: "))
                self.intentos += 1

                if intento == self.numero_secreto:
                    print(f"Felicidades, adivinaste el número en {self.intentos} intentos.")
                    break
                else:
                    print("El numero no es ese intenta de nuevo.")

            except ValueError:
                print("Por favor, ingresa un número válido.")

class Ranking:
    def __init__(self, fichero_ranking):
        self.tratamiento_fichero = TratamientoFichero(fichero_ranking)
        self.jugadores = []
        self.cargar_ranking()

    def agregar_jugador(self, nombre, intentos):
        self.jugadores.append({"nombre": nombre, "intentos": intentos})
        self.jugadores = sorted(self.jugadores, key=lambda x: x["intentos"])
        self.tratamiento_fichero.write_file(f"{nombre} {intentos}")

    def cargar_ranking(self):
        try:
            with open(self.tratamiento_fichero.nombre_fichero, "r") as f:
                for linea in f.readlines():
                    partes = linea.strip().split()
                    nombre = partes[0]
                    intentos = int(partes[1])
                    self.jugadores.append({"nombre": nombre, "intentos": intentos})
                self.jugadores = sorted(self.jugadores, key=lambda x: x["intentos"])

        except FileNotFoundError:
            print(f"No se encontró el archivo {self.tratamiento_fichero.nombre_fichero}. Creando uno nuevo.")

    def mostrar_ranking(self):
        print("------ Ranking ------")
        for i, jugador in enumerate(self.jugadores, start=1):
            print(f"{i}. {jugador['nombre']} - Intentos: {jugador['intentos']}")
        print("---------------------")

class Menu:
    def __init__(self, fichero_ranking):
        self.juego = Juego()
        self.ranking = Ranking(fichero_ranking)

    def iniciar_juego(self):
        self.juego.iniciar_juego()
        self.juego.jugar()
        nombre_jugador = input("Ingresa tu nombre para guardar tu puntuación: ")
        self.ranking.agregar_jugador(nombre_jugador, self.juego.intentos)

    def ver_ranking(self):
        self.ranking.mostrar_ranking()

    def salir(self):
        print("Gracias por jugar. ¡Hasta luego!")

if __name__ == "__main__":
    fichero_ranking = "r.txt"
    
    try:
        with open(fichero_ranking, "r"):
            pass
    except FileNotFoundError:
        print(f"No se encontró el archivo {fichero_ranking}. Creando uno nuevo.")
        with open(fichero_ranking, "w"):
            pass
    
    menu = Menu(fichero_ranking)

    while True:
        print("\n----- Menú -----")
        print("1. Iniciar juego")
        print("2. Ver ranking")
        print("3. Salir")

        opcion = input("Selecciona una opción: ")

        if opcion == "1":
            menu.iniciar_juego()
        elif opcion == "2":
            menu.ver_ranking()
        elif opcion == "3":
            menu.salir()
            break
        else:
            print("Opción no válida. Por favor, elige 1, 2 o 3.")
