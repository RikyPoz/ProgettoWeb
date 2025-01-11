#!/bin/bash

directory="./products"

cd "$directory" || exit

for file in *.*; do
  if [[ -f "$file" ]]; then
    mv "$file" "${file%.*}.png"
  fi
done