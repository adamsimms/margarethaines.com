<?php
return
'
.hascustomphonegrid #grid {
  display: none;
}

.hascustomphonegrid .cover-region-desktop {
  display: none;
}
.hascustomphonegrid .cover-region-placeholder-desktop {
  display: none;
}

.nocustomphonegrid .type-vl {
  display: none;
}

.footer-hascustomphonegrid #footer {
  display: none;
}

.tagline {
  display: none;
}

body {
  box-sizing: border-box;
}

.fp-section.row._100vh,
.fp-section.row._100vh.empty {
  min-height: 0;
}
.fp-section.row._100vh .row-inner,
.fp-section.row._100vh.empty .row-inner {
  min-height: 0 !important;
}

.lay-content.nocustomphonegrid #grid .col:not(.below, .in-view),
.lay-content.footer-nocustomphonegrid #footer .col:not(.below, .in-view),
.lay-content .cover-region-desktop .col:not(.below, .in-view) {
  transform: translate3d(0, 0, 0);
}

.lay-content.nocustomphonegrid #grid .col,
.lay-content.footer-nocustomphonegrid #footer .col,
.lay-content .cover-region-desktop .col {
  width: 100%;
}

html.flexbox .lay-content .row._100vh.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-top,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-top,
html.flexbox .lay-content .row._100vh.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-top,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-top {
  top: 0;
  position: absolute;
  margin-bottom: 0;
}
html.flexbox .lay-content .row._100vh.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-onethird,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-onethird,
html.flexbox .lay-content .row._100vh.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-onethird,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-onethird {
  top: 33%;
  transform: translate(0, -33%) !important;
  position: absolute;
  margin-bottom: 0;
}
html.flexbox .lay-content .row._100vh.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-middle,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-middle,
html.flexbox .lay-content .row._100vh.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-middle,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-middle {
  top: 50%;
  transform: translate(0, -50%) !important;
  position: absolute;
  margin-bottom: 0;
}
html.flexbox .lay-content .row._100vh.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-twothirds,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-twothirds,
html.flexbox .lay-content .row._100vh.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-twothirds,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-twothirds {
  bottom: 33%;
  transform: translate(0, -33%) !important;
  position: absolute;
  margin-bottom: 0;
}
html.flexbox .lay-content .row._100vh.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-bottom,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-2.absolute-positioning-vertically-in-apl .col.align-bottom,
html.flexbox .lay-content .row._100vh.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-bottom,
html.flexbox .lay-content .row.rowcustomheight.row-col-amt-3.absolute-positioning-vertically-in-apl .col.align-bottom {
  bottom: 0;
  position: absolute;
  margin-bottom: 0;
}

html.flexbox .lay-content .row._100vh.one-col-row .col.align-top,
html.flexbox .lay-content .row.rowcustomheight.one-col-row .col.align-top {
  align-self: start;
  margin-bottom: 0;
}
html.flexbox .lay-content .row._100vh.one-col-row .col.align-onethird,
html.flexbox .lay-content .row.rowcustomheight.one-col-row .col.align-onethird {
  align-self: start;
  margin-bottom: 0;
}
html.flexbox .lay-content .row._100vh.one-col-row .col.align-middle,
html.flexbox .lay-content .row.rowcustomheight.one-col-row .col.align-middle {
  align-self: center;
  margin-bottom: 0;
}
html.flexbox .lay-content .row._100vh.one-col-row .col.align-twothirds,
html.flexbox .lay-content .row.rowcustomheight.one-col-row .col.align-twothirds {
  align-self: end;
  margin-bottom: 0;
}
html.flexbox .lay-content .row._100vh.one-col-row .col.align-bottom,
html.flexbox .lay-content .row.rowcustomheight.one-col-row .col.align-bottom {
  align-self: end;
  margin-bottom: 0;
}

.lay-content .row {
  box-sizing: border-box;
  display: block;
}

.lay-content .row:last-child .col:last-child {
  margin-bottom: 0 !important;
}

html.no-flexbox #custom-phone-grid .col.align-middle,
html.no-flexbox #footer-custom-phone-grid .col.align-middle {
  position: relative;
  vertical-align: top;
}
html.no-flexbox #custom-phone-grid .col.align-top,
html.no-flexbox #footer-custom-phone-grid .col.align-top {
  vertical-align: top;
}
html.no-flexbox #custom-phone-grid .col.align-bottom,
html.no-flexbox #footer-custom-phone-grid .col.align-bottom {
  vertical-align: bottom;
}

.row-inner {
  box-sizing: border-box;
}

.title a,
.title {
  opacity: 1;
}

.sitetitle {
  display: none;
}

.navbar {
  display: block;
  top: 0;
  left: 0;
  bottom: auto;
  right: auto;
  width: 100%;
  z-index: 30;
  border-bottom-style: solid;
  border-bottom-width: 1px;
}

.mobile-title.image {
  font-size: 0;
}

.mobile-title.text {
  line-height: 1;
  display: inline-flex;
}
.mobile-title.text > span {
  align-self: center;
}

.mobile-title {
  z-index: 31;
  display: inline-block;
  box-sizing: border-box;
}
.mobile-title img {
  box-sizing: border-box;
  height: 100%;
}

nav.primary,
nav.second_menu,
nav.third_menu,
nav.fourth_menu {
  display: none;
}

body.mobile-menu-style_desktop_menu .burger-wrap,
body.mobile-menu-style_desktop_menu .mobile-menu-close-custom {
  display: none;
}
body.mobile-menu-style_desktop_menu nav.mobile-nav {
  z-index: 35;
  line-height: 1;
  white-space: nowrap;
}
body.mobile-menu-style_desktop_menu nav.mobile-nav li {
  vertical-align: top;
}
body.mobile-menu-style_desktop_menu nav.mobile-nav li:last-child {
  margin-right: 0 !important;
  margin-bottom: 0 !important;
}
body.mobile-menu-style_desktop_menu nav.mobile-nav ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  font-size: 0;
}
body.mobile-menu-style_desktop_menu nav.mobile-nav a {
  text-decoration: none;
}
body.mobile-menu-style_desktop_menu nav.mobile-nav span {
  border-bottom-style: solid;
  border-bottom-width: 0;
}

.html5video .html5video-customplayicon {
  max-width: 100px;
}

.cover-enabled-on-phone .cover-region {
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  width: 100%;
  min-height: 100vh;
  will-change: transform;
}

.cover-disabled-on-phone .cover-region-placeholder {
  display: none;
}

.lay-sitewide-background-video {
  display: none;
}

.cover-down-arrow-desktop {
  display: none;
}

.cover-down-arrow-phone {
  display: block;
}

.lay-content.nocustomphonegrid #grid .row.only-marquee-row {
  padding-left: 0;
  padding-right: 0;
}

.col.absolute-position.type-vl {
  position: absolute;
  margin-left: 0 !important;
  z-index: 1;
}

.hascustomphonegrid .column-wrap._100vh > .col.absolute-position:not(.lay-sticky) {
  position: absolute !important;
  margin-left: 0 !important;
  z-index: 1;
}
.hascustomphonegrid .column-wrap._100vh > .col.absolute-position.align-top:not(.lay-sticky) {
  top: 0;
}
.hascustomphonegrid .column-wrap._100vh > .col.absolute-position.align-bottom:not(.lay-sticky) {
  bottom: 0;
}

.hascustomphonegrid .column-wrap.rowcustomheight > .col.absolute-position:not(.lay-sticky) {
  position: absolute !important;
  margin-left: 0 !important;
  z-index: 1;
}
.hascustomphonegrid .column-wrap.rowcustomheight > .col.absolute-position.align-top:not(.lay-sticky) {
  top: 0;
}
.hascustomphonegrid .column-wrap.rowcustomheight > .col.absolute-position.align-bottom:not(.lay-sticky) {
  bottom: 0;
}

body.mobile-menu-style_1.mobile-menu-has-animation.mobile-menu-animation-possible.animate-mobile-menu nav.mobile-nav {
  transition: transform 300ms cubic-bezier(0.52, 0.16, 0.24, 1);
}

body.mobile-menu-style_1 nav.mobile-nav::-webkit-scrollbar {
  display: none;
}
body.mobile-menu-style_1 nav.mobile-nav {
  transform: translateY(-99999px);
  overflow-y: scroll;
  -webkit-overflow-scrolling: touch;
  white-space: normal;
  width: 100%;
  top: 0;
  left: 0;
  bottom: auto;
}
body.mobile-menu-style_1 nav.mobile-nav .current-menu-item {
  opacity: 1;
}
body.mobile-menu-style_1 nav.mobile-nav li {
  display: block;
  margin-right: 0;
  margin-bottom: 0;
  padding: 0;
}
body.mobile-menu-style_1 nav.mobile-nav li a {
  display: block;
  opacity: 1;
  border-bottom-style: solid;
  border-bottom-width: 1px;
  transition: background-color 200ms ease;
  margin: 0;
}
body.mobile-menu-style_1 nav.mobile-nav li a:hover {
  opacity: 1;
}
body.mobile-menu-style_1 nav.mobile-nav li a .span-wrap {
  border-bottom: none;
}
body.mobile-menu-style_1 nav.mobile-nav li a:hover .span-wrap {
  border-bottom: none;
}

body.mobile-menu-style_2.mobile-menu-has-animation.mobile-menu-animation-possible nav.mobile-nav {
  transition: transform 500ms cubic-bezier(0.52, 0.16, 0.24, 1);
}

body.mobile-menu-style_2 .laynav .burger-wrap {
  position: absolute;
  right: 0;
  top: 0;
}
body.mobile-menu-style_2 nav.mobile-nav.active {
  transform: translateX(0);
}
body.mobile-menu-style_2 nav.mobile-nav::-webkit-scrollbar {
  display: none;
}
body.mobile-menu-style_2 nav.mobile-nav {
  box-sizing: border-box;
  z-index: 35;
  top: 0;
  height: 100vh;
  overflow-y: scroll;
  -webkit-overflow-scrolling: touch;
  white-space: normal;
  width: 100%;
  transform: translateX(100%);
}
body.mobile-menu-style_2 nav.mobile-nav li a {
  display: block;
  margin: 0;
  box-sizing: border-box;
  width: 100%;
}

body.mobile-menu-style_3.mobile-menu-has-animation.mobile-menu-animation-possible .mobile-nav ul {
  opacity: 0;
  transition: opacity 300ms cubic-bezier(0.52, 0.16, 0.24, 1) 200ms;
}

body.mobile-menu-style_3.mobile-menu-has-animation.mobile-menu-animation-possible.mobile-menu-open .mobile-nav ul {
  opacity: 1;
}

body.mobile-menu-style_3.mobile-menu-has-animation.mobile-menu-animation-possible nav.mobile-nav {
  transition: height 500ms cubic-bezier(0.52, 0.16, 0.24, 1);
}

body.mobile-menu-style_3 nav.mobile-nav.active {
  transform: translateX(0);
}
body.mobile-menu-style_3 nav.mobile-nav::-webkit-scrollbar {
  display: none;
}
body.mobile-menu-style_3 nav.mobile-nav {
  width: 100%;
  height: 0;
  box-sizing: border-box;
  z-index: 33;
  overflow-y: scroll;
  -webkit-overflow-scrolling: touch;
  white-space: normal;
  width: 100%;
}
body.mobile-menu-style_3 nav.mobile-nav li a {
  display: block;
  margin: 0;
  box-sizing: border-box;
  width: 100%;
}

/**
 * Toggle Switch Globals
 *
 * All switches should take on the class `c-hamburger` as well as their
 * variant that will give them unique properties. This class is an overview
 * class that acts as a reset for all versions of the icon.
 */
.mobile-menu-style_1 .burger-wrap,
.mobile-menu-style_3 .burger-wrap {
  z-index: 33;
}

.lay-mobile-icons-wrap {
  z-index: 33;
  top: 0;
  right: 0;
  vertical-align: top;
}

.burger-wrap {
  padding-left: 10px;
  font-size: 0;
  box-sizing: border-box;
  display: inline-block;
  cursor: pointer;
  vertical-align: top;
}

.burger-inner {
  position: relative;
}

.burger-default {
  border-radius: 0;
  overflow: hidden;
  margin: 0;
  padding: 0;
  width: 25px;
  height: 20px;
  font-size: 0;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  box-shadow: none;
  border-radius: none;
  border: none;
  cursor: pointer;
  background-color: transparent;
}

.burger-default:focus {
  outline: none;
}

.burger-default span {
  display: block;
  position: absolute;
  left: 0;
  right: 0;
  background-color: #000;
}

.default .burger-default span {
  height: 2px;
  top: 9px;
}
.default .burger-default span::before,
.default .burger-default span::after {
  height: 2px;
}
.default .burger-default span::before {
  top: -8px;
}
.default .burger-default span::after {
  bottom: -8px;
}

.default_thin .burger-default span {
  height: 1px;
  top: 9px;
}
.default_thin .burger-default span::before,
.default_thin .burger-default span::after {
  height: 1px;
}
.default_thin .burger-default span::before {
  top: -7px;
}
.default_thin .burger-default span::after {
  bottom: -7px;
}

.burger-default span::before,
.burger-default span::after {
  position: absolute;
  display: block;
  left: 0;
  width: 100%;
  background-color: #000;
  content: "";
}

/**
 * Style 2
 *
 * Hamburger to "x" (htx). Takes on a hamburger shape, bars slide
 * down to center and transform into an "x".
 */
.burger-has-animation .burger-default {
  transition: background 0.2s;
}
.burger-has-animation .burger-default span {
  transition: background-color 0.2s 0s;
}
.burger-has-animation .burger-default span::before,
.burger-has-animation .burger-default span::after {
  transition-timing-function: cubic-bezier(0.04, 0.04, 0.12, 0.96);
  transition-duration: 0.2s, 0.2s;
  transition-delay: 0.2s, 0s;
}
.burger-has-animation .burger-default span::before {
  transition-property: top, transform;
  -webkit-transition-property: top, -webkit-transform;
}
.burger-has-animation .burger-default span::after {
  transition-property: bottom, transform;
  -webkit-transition-property: bottom, -webkit-transform;
}
.burger-has-animation .burger-default.active span::before,
.burger-has-animation .burger-default.active span::after {
  transition-delay: 0s, 0.2s;
}

/* active state, i.e. menu open */
.burger-default.active span {
  background-color: transparent !important;
}

.burger-default.active span::before {
  transform: rotate(45deg);
  top: 0;
}

.burger-default.active span::after {
  transform: rotate(-45deg);
  bottom: 0;
}

.mobile-menu-icon {
  z-index: 31;
}

.mobile-menu-icon {
  cursor: pointer;
}

.burger-custom-wrap-close {
  display: none;
}

body.mobile-menu-style_2 .mobile-nav .burger-custom-wrap-close {
  display: inline-block;
}
body.mobile-menu-style_2 .burger-custom-wrap-open {
  display: inline-block;
}

body.mobile-menu-open.mobile-menu-style_3 .burger-custom-wrap-close,
body.mobile-menu-open.mobile-menu-style_1 .burger-custom-wrap-close {
  display: inline-block;
}
body.mobile-menu-open.mobile-menu-style_3 .burger-custom-wrap-open,
body.mobile-menu-open.mobile-menu-style_1 .burger-custom-wrap-open {
  display: none;
}

/**
 * Toggle Switch Globals
 *
 * All switches should take on the class `c-hamburger` as well as their
 * variant that will give them unique properties. This class is an overview
 * class that acts as a reset for all versions of the icon.
 */
body.mobile_menu_bar_not_hidden .burger-wrap-new {
  padding-right: 5px;
}
body.mobile_menu_bar_not_hidden .lay-mobile-icons-wrap.contains-cart-icon .burger-wrap-new {
  padding-top: 6px;
}

.burger-wrap-new.burger-wrap {
  padding-left: 5px;
  padding-right: 5px;
}

.lay-mobile-icons-wrap.contains-cart-icon.custom-burger .lay-cart-icon-wrap {
  padding-top: 0;
}

.burger-new {
  border-radius: 0;
  overflow: hidden;
  margin: 0;
  padding: 0;
  width: 30px;
  height: 30px;
  font-size: 0;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  box-shadow: none;
  border-radius: none;
  border: none;
  cursor: pointer;
  background-color: transparent;
}

.burger-new:focus {
  outline: none;
}

.burger-new .bread-top,
.burger-new .bread-bottom {
  transform: none;
  z-index: 4;
  position: absolute;
  z-index: 3;
  top: 0;
  left: 0;
  width: 30px;
  height: 30px;
}

.burger-has-animation .bread-top,
.burger-has-animation .bread-bottom {
  transition: transform 0.1806s cubic-bezier(0.04, 0.04, 0.12, 0.96);
}
.burger-has-animation .bread-crust-bottom,
.burger-has-animation .bread-crust-top {
  transition: transform 0.1596s cubic-bezier(0.52, 0.16, 0.52, 0.84) 0.1008s;
}
.burger-has-animation .burger-new.active .bread-top, .burger-has-animation .burger-new.active .bread-bottom {
  transition: transform 0.3192s cubic-bezier(0.04, 0.04, 0.12, 0.96) 0.1008s;
}
.burger-has-animation .burger-new.active .bread-crust-bottom, .burger-has-animation .burger-new.active .bread-crust-top {
  transition: transform 0.1806s cubic-bezier(0.04, 0.04, 0.12, 0.96);
}

.burger-new .bread-crust-top,
.burger-new .bread-crust-bottom {
  display: block;
  width: 17px;
  height: 1px;
  background: #000;
  position: absolute;
  left: 7px;
  z-index: 1;
}

.bread-crust-top {
  top: 14px;
  transform: translateY(-3px);
}

.bread-crust-bottom {
  bottom: 14px;
  transform: translateY(3px);
}

.burger-new.active .bread-top {
  transform: rotate(45deg);
}
.burger-new.active .bread-crust-bottom {
  transform: none;
}
.burger-new.active .bread-bottom {
  transform: rotate(-45deg);
}
.burger-new.active .bread-crust-top {
  transform: none;
}

.cover-disabled-on-phone .cover-region-desktop._100vh._100vh-not-set-by-user {
  min-height: 0 !important;
}
.cover-disabled-on-phone .cover-region-desktop._100vh._100vh-not-set-by-user .cover-inner._100vh {
  min-height: 0 !important;
}
.cover-disabled-on-phone .cover-region-desktop._100vh._100vh-not-set-by-user .row._100vh {
  min-height: 0 !important;
}
.cover-disabled-on-phone .cover-region-desktop._100vh._100vh-not-set-by-user .row-inner._100vh {
  min-height: 0 !important;
}
.cover-disabled-on-phone .cover-region-desktop._100vh._100vh-not-set-by-user .column-wrap._100vh {
  min-height: 0 !important;
}

.lay-thumbnailgrid-tagfilter.mobile-one-line {
  white-space: nowrap;
  overflow-x: scroll;
  box-sizing: border-box;
  -webkit-overflow-scrolling: touch;
}

.lay-thumbnailgrid-tagfilter::-webkit-scrollbar {
  display: none;
}

.lay-thumbnailgrid-filter.mobile-one-line {
  white-space: nowrap;
  overflow-x: scroll;
  box-sizing: border-box;
  -webkit-overflow-scrolling: touch;
}

.lay-thumbnailgrid-filter::-webkit-scrollbar {
  display: none;
}

.lay-thumbnailgrid-tagfilter.mobile-one-line .tag-bubble:first-child {
  margin-left: 0 !important;
}
.lay-thumbnailgrid-tagfilter.mobile-one-line .tag-bubble:last-child {
  margin-right: 0 !important;
}

html.no-flexbox #footer-custom-phone-grid .col.align-bottom {
  vertical-align: bottom;
}
';