# Cotizador de Muebles Backend

API REST construida con Laravel para el sistema de cotización de muebles.

## Requisitos

- PHP 8.2+
- Composer
- Base de datos configurada en `.env`

## Levantar el proyecto

1. Instalar dependencias:

```bash
composer install
```

2. Configurar entorno:

```bash
cp .env.example .env
php artisan key:generate
```

3. Inicializar base de datos con datos semilla:

```bash
php artisan migrate:fresh --seed
```

4. Levantar servidor local:

```bash
php artisan serve
```

Base URL local: `http://localhost:8000/api/v1`

## Endpoints principales

- `GET|POST /acabado-tableros`
- `GET|PUT|DELETE /acabado-tableros/{acabado_tablero}`
- `GET|POST /acabado-cubre-cantos`
- `GET|PUT|DELETE /acabado-cubre-cantos/{acabado_cubre_canto}`
- `GET|POST /estructuras`
- `GET|PUT|DELETE /estructuras/{estructura}`
- `GET|POST /golas`
- `GET|PUT|DELETE /golas/{gola}`
- `GET|POST /componentes`
- `GET|PUT|DELETE /componentes/{componente}`
- `GET|POST /modulos`
- `GET|PUT|DELETE /modulos/{modulo}`
- `GET|POST /clientes`
- `GET|PUT|DELETE /clientes/{cliente}`
- `GET /clientes/{cliente}/cotizaciones`
- `GET|POST /correderas`
- `GET|PUT|DELETE /correderas/{corredera}`
- `GET|POST /compases-abatibles`
- `GET|PUT|DELETE /compases-abatibles/{compasAbatible}`
- `GET|POST /puertas`
- `GET|PUT|DELETE /puertas/{puerta}`
- `GET|POST /cotizaciones`
- `GET|PUT|DELETE /cotizaciones/{cotizacion}`
- `PUT /cotizaciones/{cotizacion}/estado`
- `GET /cotizaciones/{cotizacion}/componentes`
- `POST /cotizaciones/{cotizacion}/sync-componentes`
- `GET|POST /componentes-por-cotizacion`
- `PUT|DELETE /componentes-por-cotizacion/{componentesPorCotizacion}`
- `GET /componentes-por-cotizacion/{cotizacion}`
- `GET /componentes-por-cotizacion/cotizacion/{cotizacion}`
- `GET|POST /cantidad-por-componentes`
- `GET|PUT|DELETE /cantidad-por-componentes/{cantidadPorComponente}`
- `GET|POST /accesorios-por-componente`
- `GET|PUT|DELETE /accesorios-por-componente/{accesoriosPorComponente}`
- `GET|POST /estructura-por-componente`
- `GET|PUT|DELETE /estructura-por-componente/{estructuraPorComponente}`
- `GET|POST /acabado-cubre-canto-por-componente`
- `GET|PUT|DELETE /acabado-cubre-canto-por-componente/{acabadoCubreCantoPorComponente}`
- `GET|POST /acabado-tablero-por-componente`
- `GET|PUT|DELETE /acabado-tablero-por-componente/{acabadoTableroPorComponente}`
- `GET|POST /puertas-por-componente`
- `GET|PUT|DELETE /puertas-por-componente/{puertasPorComponente}`
- `GET|POST /gola-por-componente`
- `GET|PUT|DELETE /gola-por-componente/{golaPorComponente}`

## Testing

Ejecutar toda la suite:

```bash
php artisan test
```

Ejecutar un archivo puntual:

```bash
php artisan test tests/Feature/ComponenteTest.php
```

## Ejemplos de payload (POST/PUT)

`POST /acabado-tablero-por-componente`

```json
{
	"componente_id": 1,
	"acabado_tablero_id": 1,
	"cantidad": 2
}
```

`PUT /acabado-tablero-por-componente/{acabadoTableroPorComponente}`

```json
{
	"cantidad": 3
}
```

`POST /puertas-por-componente`

```json
{
	"componente_id": 1,
	"puerta_id": 1,
	"cantidad": 2
}
```

`PUT /puertas-por-componente/{puertasPorComponente}`

```json
{
	"cantidad": 3
}
```

`POST /gola-por-componente`

```json
{
	"componente_id": 1,
	"gola_id": 1,
	"cantidad": 2
}
```

`PUT /gola-por-componente/{golaPorComponente}`

```json
{
	"cantidad": 3
}
```

## Ejemplos de respuesta (201/200)

`POST /acabado-tablero-por-componente` (`201`)

```json
{
	"data": {
		"id": 1,
		"componente_id": 1,
		"componente_nombre": "Base 60",
		"acabado_tablero_id": 1,
		"acabado_tablero_nombre": "Melamina Blanca",
		"cantidad": 2
	}
}
```

`PUT /acabado-tablero-por-componente/{acabadoTableroPorComponente}` (`200`)

```json
{
	"data": {
		"id": 1,
		"componente_id": 1,
		"componente_nombre": "Base 60",
		"acabado_tablero_id": 1,
		"acabado_tablero_nombre": "Melamina Blanca",
		"cantidad": 3
	}
}
```

`POST /puertas-por-componente` (`201`)

```json
{
	"data": {
		"id": 1,
		"componente_id": 1,
		"componente_nombre": "Base 60",
		"puerta_id": 1,
		"puerta_nombre": "Puerta Cristal Standard",
		"cantidad": 2
	}
}
```

`PUT /puertas-por-componente/{puertasPorComponente}` (`200`)

```json
{
	"data": {
		"id": 1,
		"componente_id": 1,
		"componente_nombre": "Base 60",
		"puerta_id": 1,
		"puerta_nombre": "Puerta Cristal Standard",
		"cantidad": 3
	}
}
```

`POST /gola-por-componente` (`201`)

```json
{
	"data": {
		"id": 1,
		"componente_id": 1,
		"componente_nombre": "Base 60",
		"gola_id": 1,
		"gola_nombre": "Lateral",
		"cantidad": 2
	}
}
```

`PUT /gola-por-componente/{golaPorComponente}` (`200`)

```json
{
	"data": {
		"id": 1,
		"componente_id": 1,
		"componente_nombre": "Base 60",
		"gola_id": 1,
		"gola_nombre": "Lateral",
		"cantidad": 3
	}
}
```

## Errores comunes

`422 Unprocessable Entity` (validación)

Ejemplo: `POST /gola-por-componente` con payload vacío.

```json
{
	"message": "The componente id field is required. (and 2 more errors)",
	"errors": {
		"componente_id": [
			"The componente id field is required."
		],
		"gola_id": [
			"The gola id field is required."
		],
		"cantidad": [
			"The cantidad field is required."
		]
	}
}
```

Ejemplo: combinación duplicada en `POST /puertas-por-componente`.

```json
{
	"message": "The puerta id has already been taken.",
	"errors": {
		"puerta_id": [
			"The puerta id has already been taken."
		]
	}
}
```

`404 Not Found`

Ejemplo: `GET /gola-por-componente/99999`.

```json
{
	"message": "No query results for model [App\\Models\\GolaPorComponente] 99999"
}
```

## Resumen de códigos HTTP

### Patrón CRUD (aplica a la mayoría de recursos)

| Operación | Método | Código esperado |
|---|---|---|
| Listar colección | `GET /recurso` | `200` |
| Crear | `POST /recurso` | `201`, `422` |
| Obtener detalle | `GET /recurso/{id}` | `200`, `404` |
| Actualizar | `PUT /recurso/{id}` | `200`, `422`, `404` |
| Eliminar | `DELETE /recurso/{id}` | `204`, `404` |

Recursos que siguen este patrón:

- `/acabado-tableros`
- `/acabado-cubre-cantos`
- `/estructuras`
- `/golas`
- `/componentes`
- `/modulos`
- `/clientes`
- `/correderas`
- `/compases-abatibles`
- `/puertas`
- `/cotizaciones`
- `/cantidad-por-componentes`
- `/accesorios-por-componente`
- `/estructura-por-componente`
- `/acabado-cubre-canto-por-componente`
- `/acabado-tablero-por-componente`
- `/puertas-por-componente`
- `/gola-por-componente`

### Endpoints especiales

| Endpoint | Método | Código esperado |
|---|---|---|
| `/clientes/{id}/cotizaciones` | `GET` | `200`, `404` |
| `/cotizaciones/{id}/estado` | `PUT` | `200`, `422`, `404` |
| `/cotizaciones/{id}/componentes` | `GET` | `200`, `404` |
| `/cotizaciones/{id}/sync-componentes` | `POST` | `200`, `422`, `404` |
| `/componentes-por-cotizacion` | `GET` | `200` |
| `/componentes-por-cotizacion` | `POST` | `201`, `422` |
| `/componentes-por-cotizacion/{id}` | `PUT` | `200`, `422`, `404` |
| `/componentes-por-cotizacion/{id}` | `DELETE` | `204`, `404` |
| `/componentes-por-cotizacion/{cotizacion}` | `GET` | `200`, `404` |
| `/componentes-por-cotizacion/cotizacion/{cotizacion}` | `GET` | `200`, `404` |
