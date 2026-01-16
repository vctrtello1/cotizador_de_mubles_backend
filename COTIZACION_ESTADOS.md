# Guía de Estados de Cotización

## Descripción General

Este documento describe cómo utilizar el sistema de estados para las cotizaciones en la API. Los estados permiten seguimiento del ciclo de vida de cada cotización.

## Estados Disponibles

Las cotizaciones pueden tener uno de los siguientes estados:

- **activa**: Cotización en proceso (estado por defecto)
- **cancelada**: Cotización cancelada
- **completada**: Cotización completada

## Endpoints

### Crear una cotización

**POST** `/api/v1/cotizaciones`

Crear una nueva cotización con estado inicial (por defecto: "activa")

#### Request:
```json
{
  "cliente_id": 1,
  "fecha": "2026-01-15",
  "total": 5000.00,
  "estado": "activa"
}
```

#### Response (201 Created):
```json
{
  "data": {
    "id": 1,
    "cliente_id": 1,
    "cliente": { ... },
    "fecha": "2026-01-15",
    "total": 5000.00,
    "estado": "activa",
    "modulos": [],
    "created_at": "2026-01-15T12:34:56.000000Z",
    "updated_at": "2026-01-15T12:34:56.000000Z"
  }
}
```

### Obtener una cotización

**GET** `/api/v1/cotizaciones/{id}`

Obtener los detalles de una cotización específica

#### Response (200 OK):
```json
{
  "data": {
    "id": 1,
    "cliente_id": 1,
    "cliente": { ... },
    "fecha": "2026-01-15",
    "total": 5000.00,
    "estado": "activa",
    "modulos": [ ... ],
    "created_at": "2026-01-15T12:34:56.000000Z",
    "updated_at": "2026-01-15T12:34:56.000000Z"
  }
}
```

### Listar cotizaciones

**GET** `/api/v1/cotizaciones`

Listar todas las cotizaciones

#### Response (200 OK):
```json
{
  "data": [
    {
      "id": 1,
      "cliente_id": 1,
      "cliente": { ... },
      "fecha": "2026-01-15",
      "total": 5000.00,
      "estado": "activa",
      "modulos": [],
      "created_at": "2026-01-15T12:34:56.000000Z",
      "updated_at": "2026-01-15T12:34:56.000000Z"
    },
    {
      "id": 2,
      "cliente_id": 2,
      "cliente": { ... },
      "fecha": "2026-01-16",
      "total": 3000.00,
      "estado": "completada",
      "modulos": [],
      "created_at": "2026-01-16T12:34:56.000000Z",
      "updated_at": "2026-01-16T12:34:56.000000Z"
    }
  ]
}
```

### Actualizar una cotización

**PUT/PATCH** `/api/v1/cotizaciones/{id}`

Actualizar una cotización, incluyendo su estado

#### Request:
```json
{
  "estado": "completada"
}
```

O actualizar múltiples campos:

```json
{
  "cliente_id": 2,
  "fecha": "2026-01-20",
  "total": 6000.00,
  "estado": "cancelada"
}
```

#### Response (200 OK):
```json
{
  "data": {
    "id": 1,
    "cliente_id": 2,
    "cliente": { ... },
    "fecha": "2026-01-20",
    "total": 6000.00,
    "estado": "cancelada",
    "modulos": [],
    "created_at": "2026-01-15T12:34:56.000000Z",
    "updated_at": "2026-01-20T15:45:30.000000Z"
  }
}
```

### Eliminar una cotización

**DELETE** `/api/v1/cotizaciones/{id}`

Eliminar una cotización

#### Response (204 No Content)

## Validaciones

El campo `estado` debe ser uno de los valores válidos:
- `activa`
- `cancelada`
- `completada`

### Errores de Validación

Si se intenta crear o actualizar una cotización con un estado inválido:

**Request**:
```json
{
  "cliente_id": 1,
  "fecha": "2026-01-15",
  "total": 5000.00,
  "estado": "invalido"
}
```

**Response (422 Unprocessable Entity)**:
```json
{
  "message": "The estado field must be one of: activa, cancelada, completada.",
  "errors": {
    "estado": [
      "The estado field must be one of: activa, cancelada, completada."
    ]
  }
}
```

## Factory (Para Tests)

Se proporcionan métodos en la factory para crear cotizaciones con estados específicos:

### Uso en Tests

```php
// Crear una cotización con estado "activa"
$cotizacion = \App\Models\Cotizacion::factory()->activa()->create();

// Crear una cotización con estado "cancelada"
$cotizacion = \App\Models\Cotizacion::factory()->cancelada()->create();

// Crear una cotización con estado "completada"
$cotizacion = \App\Models\Cotizacion::factory()->completada()->create();

// Crear una cotización con estado aleatorio
$cotizacion = \App\Models\Cotizacion::factory()->create();
```

## Tests Disponibles

Se incluyen los siguientes tests para validar la funcionalidad de estados:

- `test_cotizacion_create_with_estado_activa`: Crear cotización con estado activa
- `test_cotizacion_create_with_estado_cancelada`: Crear cotización con estado cancelada
- `test_cotizacion_create_with_estado_completada`: Crear cotización con estado completada
- `test_cotizacion_create_default_estado_activa`: Verificar estado por defecto
- `test_cotizacion_update_estado`: Actualizar estado de una cotización
- `test_cotizacion_invalid_estado`: Validar rechazo de estados inválidos
- `test_cotizacion_factory_activa`: Factory para estado activa
- `test_cotizacion_factory_cancelada`: Factory para estado cancelada
- `test_cotizacion_factory_completada`: Factory para estado completada
- `test_cotizacion_show_includes_estado`: Verificar estado en respuesta

### Ejecutar Tests

```bash
# Ejecutar todos los tests
./vendor/bin/phpunit

# Ejecutar solo tests de cotización
./vendor/bin/phpunit tests/Feature/CotizacionTest.php

# Ejecutar un test específico
./vendor/bin/phpunit tests/Feature/CotizacionTest.php --filter test_cotizacion_update_estado
```

## Migraciones

La migración `2026_01_16_003158_add_estado_to_cotizaciones_table` agrega:

- Columna `estado` de tipo ENUM con valores: 'activa', 'cancelada', 'completada'
- Valor por defecto: 'activa'
- Posición: después de la columna `total`

### Revertir migración

```bash
php artisan migrate:rollback --step=1
```

## Modelo Cotizacion

El modelo `Cotizacion` incluye:

- Campo `estado` en `$fillable` para asignación en masa
- Atributo por defecto: `'estado' => 'activa'`

## Resource API

El `CotizacionResource` incluye el campo `estado` en todas las respuestas JSON.

## Changelog

- **2026-01-16**: Agregado sistema de estados de cotización
  - Migración creada
  - Factory actualizada con métodos para estados específicos
  - Tests agregados (10 nuevos tests)
  - Validaciones actualizadas
  - Resource API actualizado
