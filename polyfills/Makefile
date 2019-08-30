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

SASS_DEV = npm run sass-dev
SASS_DIST = npm run sass-dist
SASSCOMP = --output-style compressed

all: dev dist

dev: css-dev js-dev

dist: css-dist

#-----------------------------------------------------------------------
# CSS

css: css-dev css-dist

css-dev: css-dev-ie css-dev-normal

css-dev-ie:
	$(SASS_DEV) -- $(SRCDIR)/polyfills.ie.scss $(DISTDIR)/polyfills.ie.css

css-dev-normal:
	$(SASS_DEV) -- $(SRCDIR)/polyfills.scss $(DISTDIR)/polyfills.css

#-----------------------------------------------------------------------

css-dist: css-dist-ie css-dist-normal

css-dist-ie:
	$(SASS_DIST) -- $(SRCDIR)/polyfills.ie.scss $(DISTDIR)/polyfills.ie.min.css

css-dist-normal:
	$(SASS_DIST) -- $(SRCDIR)/polyfills.scss $(DISTDIR)/polyfills.min.css

#-----------------------------------------------------------------------
# Javascript - TODO no compacting yet

js: js-dev

js-dev:
	npm run rollup-dev

js-dist:
	npm run rollup-dist
	mv $(DISTDIR)/polyfills.js  $(DISTDIR)/polyfills.min.js
	mv $(DISTDIR)/polyfills.ie.js  $(DISTDIR)/polyfills.ie.min.js

#----------------------------------------------------------------------------

clean:
	rm $(DISTDIR)/*

setup:
	npm install

#----------------------------------------------------------------------------
# Copyright (C) 2019 Jaypha.
# License: BSL-1.0
# Author: Jason den Dulk
#

#cat $(BUILDDIR)/javascript/*.js > $(ASSETDIR)/js/staff.js

