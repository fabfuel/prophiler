#!/usr/bin/env bash

git clone -q --depth=1 https://github.com/phalcon/cphalcon.git -b master
cd cphalcon/build; sudo ./install
