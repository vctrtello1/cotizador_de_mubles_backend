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
