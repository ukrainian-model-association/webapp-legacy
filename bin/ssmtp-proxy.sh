#!/usr/bin/env bash

log() {
  local execExpr="${EXEC_PATH} ${TARGET_ARGS}"

  echo "[$(date +"%H:%M:%S %d/%m/%Y $$")] ${execExpr}" >>"${LOG_PATH}"
  tee -a "${LOG_PATH}" | ${TARGET} "${TARGET_ARGS}"
  echo -e "\n---\n\n" >>"${LOG_PATH}"
}

set -e
EXEC_PATH="${BASH_SOURCE[0]}"
TARGET=/usr/sbin/ssmtp-origin
TARGET_ARGS="$*"
LOGS_DIR=/var/log
LOG_FILE="${EXEC_PATH##*/}.log"
LOG_PATH="${LOGS_DIR}/ssmtp.log"

log

