# Arquitectura del sistema Catastro TDF

Este documento describe la estructura principal del codigo fuente y el flujo de ejecucion de la aplicacion.

## Vista general de arquitectura

```mermaid
flowchart TB
    U[Usuario / Navegador]

    subgraph WEB["Capa web PHP (monolito)"]
      IDX[index.php y pantallas de modulo]
      LYT[tdf_header.php / tdf_menu.php / tdf_footer.php]
      CORE[Common.php / Template.php / Sorter.php / Navigator.php]
    end

    subgraph MOD["Modulos funcionales"]
      TEC[tecnica/]
      GES[gestion/]
      PZA[piezas/]
      PAR[parametro/]
      PLA[planchetas/]
      PRE[previsado/]
      USR[usuarios/]
      ADM[administracion/]
      OTH[otros modulos]
    end

    subgraph EVT["Logica por pantalla"]
      PG[pagina.php]
      EV[pagina_events.php]
      PERM[scripts/permisos1.php]
      HELP[scripts/myFunctions.php]
    end

    subgraph DAT["Datos"]
      DBPHP[db_adapter.php / db_mysql.php / db_array.php]
      DS[clases DataSource clsDB*]
      DB[(Base de datos)]
    end

    subgraph API["Servicios auxiliares"]
      SVC[services/*.php]
      JS[js/ + Functions.js + DatePicker.js]
    end

    subgraph RPT["Reportes y documentos"]
      REP[reportes/*.php]
      PDF[scripts/tcpdf + fpdf + dompdf]
      MAIL[scripts/PHPMailer]
    end

    U --> IDX
    IDX --> CORE
    IDX --> LYT
    IDX --> MOD

    MOD --> PG
    PG --> EV
    EV --> PERM
    EV --> HELP
    PG --> DS
    DS --> DBPHP
    DBPHP --> DB

    JS --> SVC
    SVC --> DS

    PG --> REP
    REP --> PDF
    EV --> MAIL
```

## Flujo tipico de una pantalla

```mermaid
sequenceDiagram
    autonumber
    participant B as Navegador
    participant P as modulo/pantalla.php
    participant E as modulo/pantalla_events.php
    participant C as Common/Template/Navigator
    participant A as scripts/permisos1.php
    participant D as DataSource clsDB*
    participant DB as Base de datos

    B->>P: GET /modulo/pantalla.php
    P->>C: include_once librerias base
    P->>E: include_once pantalla_events.php
    E->>A: validar permisos y contexto
    P->>D: cargar grids/records
    D->>DB: consultar/actualizar datos
    DB-->>D: resultados
    D-->>P: datasets
    P-->>B: HTML renderizado
```

## Notas de organizacion

- Patron dominante: `pagina.php` + `pagina_events.php`.
- Estructura de clases frecuente: `clsGrid*`, `clsRecord*`, `*DataSource`.
- Los endpoints en `services/` alimentan componentes de UI dinamicos (autocompletes, listas dependientes y respuestas JSON).
- El sistema centraliza layout en archivos `tdf_*` y utilidades en `scripts/`.
