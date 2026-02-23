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

- `GET|POST /materiales`
- `GET|PUT|DELETE /materiales/{material}`
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
- `GET|POST /cantidad-por-materiales`
- `GET|PUT|DELETE /cantidad-por-materiales/{cantidadPorMaterial}`
- `GET|POST /cantidad-por-componentes`
- `GET|PUT|DELETE /cantidad-por-componentes/{cantidadPorComponente}`
- `GET|POST /accesorios-por-componente`
- `GET|PUT|DELETE /accesorios-por-componente/{accesoriosPorComponente}`
- `GET|POST /materiales-por-componente`
- `GET|PUT|DELETE /materiales-por-componente/{materialesPorComponente}`
- `GET|POST /estructura-por-componente`
- `GET|PUT|DELETE /estructura-por-componente/{estructuraPorComponente}`

### Tableros por componente
- `GET|POST /tableros-por-componente`
- `GET|PUT|DELETE /tableros-por-componente/{tablerosPorComponente}`

Soporta `include` opcional para detalle de relaciones:

- `GET /tableros-por-componente` → respuesta ligera (sin `componente` ni `tablero`).
- `GET /tableros-por-componente?include=componente` → incluye solo detalle de `componente`.
- `GET /tableros-por-componente?include=tablero` → incluye solo detalle de `tablero`.
- `GET /tableros-por-componente?include=componente,tablero` → incluye ambos detalles.
- `GET /tableros-por-componente/{tablerosPorComponente}` → respuesta ligera por defecto.
- `GET /tableros-por-componente/{tablerosPorComponente}?include=componente,tablero` → detalle completo en `show`.

Ejemplos `curl`:

```bash
# Index ligero
curl -X GET "http://localhost:8000/api/v1/tableros-por-componente"

# Index con detalle completo
curl -X GET "http://localhost:8000/api/v1/tableros-por-componente?include=componente,tablero"

# Show ligero
curl -X GET "http://localhost:8000/api/v1/tableros-por-componente/1"

# Show con detalle completo
curl -X GET "http://localhost:8000/api/v1/tableros-por-componente/1?include=componente,tablero"

# Crear registro
curl -X POST "http://localhost:8000/api/v1/tableros-por-componente" \
	-H "Content-Type: application/json" \
	-d '{
		"componente_id": 1,
		"tablero_id": 2,
		"cantidad": 3
	}'

# Actualizar cantidad
curl -X PUT "http://localhost:8000/api/v1/tableros-por-componente/1" \
	-H "Content-Type: application/json" \
	-d '{
		"cantidad": 5
	}'
```

## Testing

Ejecutar toda la suite:

```bash
php artisan test
```

Ejecutar un archivo puntual:

```bash
php artisan test tests/Feature/MaterialesTest.php
```
