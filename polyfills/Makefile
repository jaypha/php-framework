#----------------------------------------------------------------------------
#
#----------------------------------------------------------------------------
#
#----------------------------------------------------------------------------

# These may be system dependent, edit if necessary (but do not submit)

# File System defs.

# Local build defs

DISTDIR = dist

SRCDIR = src

# Development Environment Variables

#YUI = java -jar progs/yuicompressor-2.4.8.jar

#SASS = sassc -I $(SRCDIR) -I node_modules
#SASSCOMP = --style compressed

SASS = npm run sass
SASSCOMP = --output-style compressed

all: dev

dev: css js

#-----------------------------------------------------------------------
# CSS

css: css-ie css-normal

css-ie:
	$(SASS) -- $(SRCDIR)/polyfills.ie.scss $(DISTDIR)/ie/polyfills.ie.css

css-normal:
	$(SASS) -- $(SRCDIR)/polyfills.scss $(DISTDIR)/modern/polyfills.css

#-----------------------------------------------------------------------
# Javascript

js:
	npm run build

#----------------------------------------------------------------------------

setup:
	npm install

#----------------------------------------------------------------------------
# Copyright (C) 2019 Jaypha.
# License: BSL-1.0
# Author: Jason den Dulk
#

#cat $(BUILDDIR)/javascript/*.js > $(ASSETDIR)/js/staff.js

