#----------------------------------------------------------------------------
#
#----------------------------------------------------------------------------
#
#----------------------------------------------------------------------------

# Directory of this makefile
PROJDIR:=$(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))

# File System defs.

NGINXETC = /etc/nginx

# Local build defs

SRCDIR = $(PROJDIR)/src
ASSETDIR = $(PROJDIR)/assets


# Development Environment Variables

YUI = java -jar progs/yuicompressor-2.4.8.jar

SASS = sassc -I $(SRCDIR)


all: dev

dev: js-dev css-dev

css-dev:

js: js-dev

js-dev:
	npm run rollup

#----------------------------------------------------------------------------
#

