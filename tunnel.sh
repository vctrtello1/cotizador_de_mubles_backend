#!/bin/bash
# Túnel SSH hacia la base de datos PostgreSQL remota
# Reenvía localhost:5433 -> 72.61.71.185:15432 -> (docker socat) -> cotizador DB:5432

REMOTE="root@72.61.71.185"
REMOTE_PASS="Purru#43"
SSH_OPTS="-o StrictHostKeyChecking=no -o ServerAliveInterval=30 -o ServerAliveCountMax=10"

echo "Verificando contenedor socat en el servidor remoto..."
CONTAINER_RUNNING=$(sshpass -p "$REMOTE_PASS" ssh $SSH_OPTS $REMOTE \
  "docker ps --filter name=pg-tunnel --format '{{.Names}}'")

if [ -z "$CONTAINER_RUNNING" ]; then
  echo "Iniciando contenedor socat en el servidor remoto..."
  sshpass -p "$REMOTE_PASS" ssh $SSH_OPTS $REMOTE \
    "docker run -d --rm --network dokploy-network -p 127.0.0.1:15432:15432 --name pg-tunnel alpine/socat TCP4-LISTEN:15432,reuseaddr,fork TCP4:cotizador-de-muebles-dbcotizador-kwyy3h:5432"
  sleep 2
else
  echo "Contenedor socat ya en ejecución."
fi

echo "Iniciando túnel SSH: localhost:5433 -> remoto:15432 -> PostgreSQL:5432"
echo "Presiona Ctrl+C para cerrar el túnel."

sshpass -p "$REMOTE_PASS" ssh $SSH_OPTS \
  -L 5433:127.0.0.1:15432 \
  $REMOTE \
  -N
