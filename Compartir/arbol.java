package Arbol;

import java.util.Arrays;
import java.util.LinkedList;

public class arbol {

    static int n = 8;
    int estadoInicial[] = new int[n];
    nodo root = null;
    static LinkedList<int[]> soluciones;

    public arbol() {
        root = new nodo(estadoInicial);
        soluciones = new LinkedList<>();
    }

    public void generarHijos(nodo a, int pos) {
        if (validarEstado(a.estado, pos)) {
            if (pos < n) {
                for (int i = 0; i < n; i++) {
                    int nu[] = new int[n];
                    for (int j = 0; j < n; j++) {
                        nu[j] = a.estado[j];
                    }
                    nu[pos] = i + 1;
                    nodo nuevo = new nodo(nu);
                    if (validarEstado(nu, pos + 1)) {
                        a.hijos.add(nuevo);
                        generarHijos(nuevo, pos + 1);
                    }
                }
            } else {
                soluciones.addLast(a.estado);
            }
        }
    }

    public boolean igual(int[] a, int[] b) {
        for (int i = 0; i < n; i++) {
            if (a[i] != b[i]) {
                return false;
            }
        }
        return true;
    }

    public void imprimirComoMatriz(int[] input) {
        int m[][] = new int[n][n];
        for (int i = 0; i < input.length; i++) {
            if (input[i] != 0) {
                m[input[i] - 1][i] = 1;
            }
        }
        for (int i = 0; i < n; i++) {
            for (int j = 0; j < n; j++) {
                System.out.print(m[i][j] + " ");
            }
            System.out.println("");
        }
        System.out.println("");
    }

    public void imprimirSoluciones() {
        for (int i = 0; i < soluciones.size(); i++) {
            imprimirComoMatriz(soluciones.get(i));
        }
    }

    public boolean validarEstado(int[] a, int pos) {
        for (int i = 0; i < pos; i++) {
            for (int j = i + 1; j < pos; j++) {
                if ((a[i] == a[j]) || (Math.abs(i - j) == Math.abs(a[i] - a[j]))) {
                    return false;
                }
            }
        }
        return true;
    }

    public void imprimirArbolProfundidad(nodo a) {
        for (int i = 0; i < a.hijos.size(); i++) {
            imprimirArbolProfundidad(a.hijos.get(i));
            imprimirComoMatriz(a.hijos.get(i).estado);
        }
    }

    public void imprimirAnchura() {
        LinkedList<nodo> cola = new LinkedList();
        cola.add(root);
        while (!cola.isEmpty()) {
            nodo ac = cola.getFirst();
            for (int i = 0; i < ac.hijos.size(); i++) {
                cola.addLast(ac.hijos.get(i));
            }
            imprimirComoMatriz(ac.estado);
            cola.removeFirst();
        }
    }

    int cot = 1;

    public void buscarEnProfundidad(nodo a, int b[], boolean bandera) {
        cot++;
        if (igual(a.estado, b)) {
            bandera = true;
            System.out.println("Profundidad: " + cot);
            return;
        }
        for (int i = 0; i < a.hijos.size(); i++) {
            buscarEnProfundidad(a.hijos.get(i), b, bandera);
        }
    }

    public void buscarEnProfundidad(int[] b) {
        boolean bandera = false;
        buscarEnProfundidad(root, b, bandera);
    }

    public void buscarEnAnchura(int[] b) {
        LinkedList<nodo> cola = new LinkedList();
        cola.add(root);
        int cont = 0;
        while (!cola.isEmpty()) {
            nodo ac = cola.getFirst();
            for (int i = 0; i < ac.hijos.size(); i++) {
                cola.addLast(ac.hijos.get(i));
            }
            if (igual(b, ac.estado)) {
                System.out.println("Anchura: " + cont);
            }
            cola.removeFirst();
            cont++;
        }
    }

    int[][] primos = {{2, 3, 5, 7, 11, 13, 17, 19}, {23, 29, 31, 37, 41, 43, 47, 53}, {59, 61, 67, 71, 73, 79, 83, 89}, {97, 101, 103, 107, 109, 113, 127, 131}, {137, 139, 149, 151, 157, 163, 167, 173}, {179, 181, 191, 193, 197, 199, 211, 223}, {227, 229, 233, 239, 241, 251, 257, 263}, {269, 271, 277, 281, 283, 293, 307, 311}};

    public double Hue(int[] a) {
        double res = 1;
        for (int i = 0; i < n; i++) {
            if (a[i] != 0) {
                res = res * primos[a[i] - 1][i];
            }
        }
        return res;
    }

    LinkedList<nodo> heur = new LinkedList<>();
    int ct = 0;
    public void busquedaHeu(int[] b) {
        nodo ac = root;
        double n = Hue(b);
        int y=0;
        while (true) {
            ct++;
           // System.out.println(Hue(ac.estado));
            if (Hue(ac.estado) == n ) {
                System.out.println("Heureliana: " + ct);
                return;
            }
            for (int i = 0; i < ac.hijos.size(); i++) {
                //System.out.println(n+" --- "+Hue(ac.hijos.get(i).estado)+" --- "+(n / Hue(ac.estado)));
                //System.out.println((n / Hue(ac.estado)) % 1 == 0);
                //imprimirComoMatriz(ac.hijos.get(i).estado);
                    if ((n / Hue(ac.hijos.get(i).estado)) % 1 == 0) {
                    ac = ac.hijos.get(i);
                    heur.add(ac);
                    //n=n / Hue(ac.estado);
                    break;
                }
            }
            y++;
        }
    }

    public void imprimirHeuristica() {
        for (int i = 0; i < heur.size(); i++) {
            imprimirComoMatriz(heur.get(i).estado);
        }
    }

    int totalNodos = 0;

    public void contarNodos(nodo a) {
        totalNodos = totalNodos + 1;
        for (int i = 0; i < a.hijos.size(); i++) {
            contarNodos(a.hijos.get(i));
        }
    }
}
