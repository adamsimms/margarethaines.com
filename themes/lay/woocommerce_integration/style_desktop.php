<?php
return
'
.lay-woocommerce-headline {
  font-family: HelveticaNeue, Helvetica, sans-serif, -apple-system;
  margin-top: 0;
  font-size: 25px !important;
  letter-spacing: 0.02em;
  font-weight: 800;
  display: none;
}

.woocommerce #main .summary {
  font-size: 18px !important;
  letter-spacing: 0.02em;
  color: black !important;
  font-weight: 100 !important;
  line-height: 1.2 !important;
  font-family: HelveticaNeue, Helvetica, sans-serif, -apple-system !important;
}
.woocommerce #main .summary p {
  font-size: 18px !important;
  letter-spacing: 0.02em;
  color: black !important;
  font-weight: 100 !important;
  line-height: 1.2 !important;
  font-family: HelveticaNeue, Helvetica, sans-serif, -apple-system !important;
}

body.woocommerce-page .lay-content {
  min-height: 0 !important;
}

.woocommerce #main p {
  font-size: 15px;
}

.product-overview {
  margin: 0 20px;
}

body.privacy-policy #main {
  max-width: 1024px;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
}

.lay-cart-icon-wrap {
  display: none;
}

.summary {
  padding-left: 20px;
}

/**
 * woocommerce-layout.scss
 * Applies layout to the default WooCommerce frontend design
 */
/**
 * Imports
 */
/**
 * Deprecated
 * Fallback for bourbon equivalent
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Vendor prefix no longer required.
 */
/**
 * Deprecated
 * Use bourbon mixin instead `@include transform(scale(1.5));`
 */
/**
 * Deprecated
 * Use bourbon mixin instead `@include box-sizing(border-box);`
 */
/**
 * Objects
 */
/**
 * WooCommerce CSS Variables
 */
/**
 * Styling begins
 */
.woocommerce, .woocommerce-page {
  /**
   * General layout styles
   */
  /**
   * Product page
   */
  /**
   * Product loops
   */
  /**
   * Cart page
   */
  /**
   * Cart sidebar
   */
  /**
   * Forms
   */
  /**
   * oEmbeds
   */
}
.woocommerce .col2-set, .woocommerce-page .col2-set {
  *zoom: 1;
  width: 100%;
}
.woocommerce .col2-set::before, .woocommerce .col2-set::after, .woocommerce-page .col2-set::before, .woocommerce-page .col2-set::after {
  content: " ";
  display: table;
}
.woocommerce .col2-set::after, .woocommerce-page .col2-set::after {
  clear: both;
}
.woocommerce .col2-set .col-1, .woocommerce-page .col2-set .col-1 {
  float: left;
  width: 48%;
}
.woocommerce .col2-set .col-2, .woocommerce-page .col2-set .col-2 {
  float: right;
  width: 48%;
}
.woocommerce div.product div.images,
.woocommerce #content div.product div.images, .woocommerce-page div.product div.images,
.woocommerce-page #content div.product div.images {
  display: inline-block;
  width: 48%;
  max-width: 500px;
  vertical-align: top;
}
.woocommerce div.product div.thumbnails,
.woocommerce #content div.product div.thumbnails, .woocommerce-page div.product div.thumbnails,
.woocommerce-page #content div.product div.thumbnails {
  *zoom: 1;
}
.woocommerce div.product div.thumbnails::before, .woocommerce div.product div.thumbnails::after,
.woocommerce #content div.product div.thumbnails::before,
.woocommerce #content div.product div.thumbnails::after, .woocommerce-page div.product div.thumbnails::before, .woocommerce-page div.product div.thumbnails::after,
.woocommerce-page #content div.product div.thumbnails::before,
.woocommerce-page #content div.product div.thumbnails::after {
  content: " ";
  display: table;
}
.woocommerce div.product div.thumbnails::after,
.woocommerce #content div.product div.thumbnails::after, .woocommerce-page div.product div.thumbnails::after,
.woocommerce-page #content div.product div.thumbnails::after {
  clear: both;
}
.woocommerce div.product div.thumbnails.columns-1 a,
.woocommerce #content div.product div.thumbnails.columns-1 a, .woocommerce-page div.product div.thumbnails.columns-1 a,
.woocommerce-page #content div.product div.thumbnails.columns-1 a {
  width: 100%;
  margin-right: 0;
  float: none;
}
.woocommerce div.product div.thumbnails.columns-2 a,
.woocommerce #content div.product div.thumbnails.columns-2 a, .woocommerce-page div.product div.thumbnails.columns-2 a,
.woocommerce-page #content div.product div.thumbnails.columns-2 a {
  width: 48%;
}
.woocommerce div.product div.thumbnails.columns-4 a,
.woocommerce #content div.product div.thumbnails.columns-4 a, .woocommerce-page div.product div.thumbnails.columns-4 a,
.woocommerce-page #content div.product div.thumbnails.columns-4 a {
  width: 22.15%;
}
.woocommerce div.product div.thumbnails.columns-5 a,
.woocommerce #content div.product div.thumbnails.columns-5 a, .woocommerce-page div.product div.thumbnails.columns-5 a,
.woocommerce-page #content div.product div.thumbnails.columns-5 a {
  width: 16.9%;
}
.woocommerce div.product .woocommerce-tabs,
.woocommerce #content div.product .woocommerce-tabs, .woocommerce-page div.product .woocommerce-tabs,
.woocommerce-page #content div.product .woocommerce-tabs {
  clear: both;
}
.woocommerce div.product .woocommerce-tabs ul.tabs,
.woocommerce #content div.product .woocommerce-tabs ul.tabs, .woocommerce-page div.product .woocommerce-tabs ul.tabs,
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs {
  *zoom: 1;
}
.woocommerce div.product .woocommerce-tabs ul.tabs::before, .woocommerce div.product .woocommerce-tabs ul.tabs::after,
.woocommerce #content div.product .woocommerce-tabs ul.tabs::before,
.woocommerce #content div.product .woocommerce-tabs ul.tabs::after, .woocommerce-page div.product .woocommerce-tabs ul.tabs::before, .woocommerce-page div.product .woocommerce-tabs ul.tabs::after,
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs::before,
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs::after {
  content: " ";
  display: table;
}
.woocommerce div.product .woocommerce-tabs ul.tabs::after,
.woocommerce #content div.product .woocommerce-tabs ul.tabs::after, .woocommerce-page div.product .woocommerce-tabs ul.tabs::after,
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs::after {
  clear: both;
}
.woocommerce div.product .woocommerce-tabs ul.tabs li,
.woocommerce #content div.product .woocommerce-tabs ul.tabs li, .woocommerce-page div.product .woocommerce-tabs ul.tabs li,
.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li {
  display: inline-block;
}
.woocommerce div.product #reviews .comment,
.woocommerce #content div.product #reviews .comment, .woocommerce-page div.product #reviews .comment,
.woocommerce-page #content div.product #reviews .comment {
  *zoom: 1;
}
.woocommerce div.product #reviews .comment::before, .woocommerce div.product #reviews .comment::after,
.woocommerce #content div.product #reviews .comment::before,
.woocommerce #content div.product #reviews .comment::after, .woocommerce-page div.product #reviews .comment::before, .woocommerce-page div.product #reviews .comment::after,
.woocommerce-page #content div.product #reviews .comment::before,
.woocommerce-page #content div.product #reviews .comment::after {
  content: " ";
  display: table;
}
.woocommerce div.product #reviews .comment::after,
.woocommerce #content div.product #reviews .comment::after, .woocommerce-page div.product #reviews .comment::after,
.woocommerce-page #content div.product #reviews .comment::after {
  clear: both;
}
.woocommerce div.product #reviews .comment img,
.woocommerce #content div.product #reviews .comment img, .woocommerce-page div.product #reviews .comment img,
.woocommerce-page #content div.product #reviews .comment img {
  float: right;
  height: auto;
}
.woocommerce ul.products li.product, .woocommerce-page ul.products li.product {
  padding: 0;
  position: relative;
}
.woocommerce ul.products.columns-1 li.product, .woocommerce-page ul.products.columns-1 li.product {
  width: 100%;
  margin-right: 0;
}
.woocommerce ul.products.columns-2 li.product, .woocommerce-page ul.products.columns-2 li.product {
  width: 48%;
}
.woocommerce ul.products.columns-3 li.product, .woocommerce-page ul.products.columns-3 li.product {
  width: 30.75%;
}
.woocommerce ul.products.columns-5 li.product, .woocommerce-page ul.products.columns-5 li.product {
  width: 16.95%;
}
.woocommerce ul.products.columns-6 li.product, .woocommerce-page ul.products.columns-6 li.product {
  width: 13.5%;
}
.woocommerce.columns-1 ul.products li.product, .woocommerce-page.columns-1 ul.products li.product {
  width: 100%;
  margin-right: 0;
}
.woocommerce.columns-2 ul.products li.product, .woocommerce-page.columns-2 ul.products li.product {
  width: 48%;
}
.woocommerce.columns-3 ul.products li.product, .woocommerce-page.columns-3 ul.products li.product {
  width: 30.75%;
}
.woocommerce.columns-5 ul.products li.product, .woocommerce-page.columns-5 ul.products li.product {
  width: 16.95%;
}
.woocommerce.columns-6 ul.products li.product, .woocommerce-page.columns-6 ul.products li.product {
  width: 13.5%;
}
.woocommerce .woocommerce-result-count, .woocommerce-page .woocommerce-result-count {
  float: left;
}
.woocommerce .woocommerce-ordering, .woocommerce-page .woocommerce-ordering {
  float: right;
}
.woocommerce .woocommerce-pagination ul.page-numbers, .woocommerce-page .woocommerce-pagination ul.page-numbers {
  *zoom: 1;
}
.woocommerce .woocommerce-pagination ul.page-numbers::before, .woocommerce .woocommerce-pagination ul.page-numbers::after, .woocommerce-page .woocommerce-pagination ul.page-numbers::before, .woocommerce-page .woocommerce-pagination ul.page-numbers::after {
  content: " ";
  display: table;
}
.woocommerce .woocommerce-pagination ul.page-numbers::after, .woocommerce-page .woocommerce-pagination ul.page-numbers::after {
  clear: both;
}
.woocommerce .woocommerce-pagination ul.page-numbers li, .woocommerce-page .woocommerce-pagination ul.page-numbers li {
  display: inline-block;
}
.woocommerce table.cart img,
.woocommerce #content table.cart img, .woocommerce-page table.cart img,
.woocommerce-page #content table.cart img {
  height: auto;
}
.woocommerce table.cart td.actions,
.woocommerce #content table.cart td.actions, .woocommerce-page table.cart td.actions,
.woocommerce-page #content table.cart td.actions {
  text-align: right;
}
.woocommerce table.cart td.actions .input-text,
.woocommerce #content table.cart td.actions .input-text, .woocommerce-page table.cart td.actions .input-text,
.woocommerce-page #content table.cart td.actions .input-text {
  width: 80px;
}
.woocommerce table.cart td.actions .coupon,
.woocommerce #content table.cart td.actions .coupon, .woocommerce-page table.cart td.actions .coupon,
.woocommerce-page #content table.cart td.actions .coupon {
  float: left;
}
.woocommerce table.cart td.actions .coupon label,
.woocommerce #content table.cart td.actions .coupon label, .woocommerce-page table.cart td.actions .coupon label,
.woocommerce-page #content table.cart td.actions .coupon label {
  display: none;
}
.woocommerce .cart-collaterals, .woocommerce-page .cart-collaterals {
  *zoom: 1;
  width: 100%;
}
.woocommerce .cart-collaterals::before, .woocommerce .cart-collaterals::after, .woocommerce-page .cart-collaterals::before, .woocommerce-page .cart-collaterals::after {
  content: " ";
  display: table;
}
.woocommerce .cart-collaterals::after, .woocommerce-page .cart-collaterals::after {
  clear: both;
}
.woocommerce .cart-collaterals .related, .woocommerce-page .cart-collaterals .related {
  width: 30.75%;
  float: left;
}
.woocommerce .cart-collaterals .cross-sells, .woocommerce-page .cart-collaterals .cross-sells {
  width: 48%;
  float: left;
}
.woocommerce .cart-collaterals .cross-sells ul.products, .woocommerce-page .cart-collaterals .cross-sells ul.products {
  float: none;
}
.woocommerce .cart-collaterals .cross-sells ul.products li, .woocommerce-page .cart-collaterals .cross-sells ul.products li {
  width: 48%;
}
.woocommerce .cart-collaterals .shipping_calculator, .woocommerce-page .cart-collaterals .shipping_calculator {
  width: 48%;
  *zoom: 1;
  clear: right;
  float: right;
}
.woocommerce .cart-collaterals .shipping_calculator::before, .woocommerce .cart-collaterals .shipping_calculator::after, .woocommerce-page .cart-collaterals .shipping_calculator::before, .woocommerce-page .cart-collaterals .shipping_calculator::after {
  content: " ";
  display: table;
}
.woocommerce .cart-collaterals .shipping_calculator::after, .woocommerce-page .cart-collaterals .shipping_calculator::after {
  clear: both;
}
.woocommerce .cart-collaterals .shipping_calculator .col2-set .col-1,
.woocommerce .cart-collaterals .shipping_calculator .col2-set .col-2, .woocommerce-page .cart-collaterals .shipping_calculator .col2-set .col-1,
.woocommerce-page .cart-collaterals .shipping_calculator .col2-set .col-2 {
  width: 47%;
}
.woocommerce ul.cart_list li,
.woocommerce ul.product_list_widget li, .woocommerce-page ul.cart_list li,
.woocommerce-page ul.product_list_widget li {
  *zoom: 1;
}
.woocommerce ul.cart_list li::before, .woocommerce ul.cart_list li::after,
.woocommerce ul.product_list_widget li::before,
.woocommerce ul.product_list_widget li::after, .woocommerce-page ul.cart_list li::before, .woocommerce-page ul.cart_list li::after,
.woocommerce-page ul.product_list_widget li::before,
.woocommerce-page ul.product_list_widget li::after {
  content: " ";
  display: table;
}
.woocommerce ul.cart_list li::after,
.woocommerce ul.product_list_widget li::after, .woocommerce-page ul.cart_list li::after,
.woocommerce-page ul.product_list_widget li::after {
  clear: both;
}
.woocommerce ul.cart_list li img,
.woocommerce ul.product_list_widget li img, .woocommerce-page ul.cart_list li img,
.woocommerce-page ul.product_list_widget li img {
  float: right;
  height: auto;
}
.woocommerce form .form-row, .woocommerce-page form .form-row {
  *zoom: 1;
}
.woocommerce form .form-row::before, .woocommerce form .form-row::after, .woocommerce-page form .form-row::before, .woocommerce-page form .form-row::after {
  content: " ";
  display: table;
}
.woocommerce form .form-row::after, .woocommerce-page form .form-row::after {
  clear: both;
}
.woocommerce form .form-row label, .woocommerce-page form .form-row label {
  display: block;
}
.woocommerce form .form-row label.checkbox, .woocommerce-page form .form-row label.checkbox {
  display: inline;
}
.woocommerce form .form-row select, .woocommerce-page form .form-row select {
  width: 100%;
}
.woocommerce form .form-row .input-text, .woocommerce-page form .form-row .input-text {
  box-sizing: border-box;
  width: 100%;
}
.woocommerce form .form-row-first,
.woocommerce form .form-row-last, .woocommerce-page form .form-row-first,
.woocommerce-page form .form-row-last {
  width: 47%;
  overflow: visible;
}
.woocommerce form .form-row-first, .woocommerce-page form .form-row-first {
  float: left;
  /*rtl:raw:
  float: right;
  */
}
.woocommerce form .form-row-last, .woocommerce-page form .form-row-last {
  float: right;
}
.woocommerce form .form-row-wide, .woocommerce-page form .form-row-wide {
  clear: both;
}
.woocommerce .woocommerce-billing-fields,
.woocommerce .woocommerce-shipping-fields, .woocommerce-page .woocommerce-billing-fields,
.woocommerce-page .woocommerce-shipping-fields {
  *zoom: 1;
}
.woocommerce .woocommerce-billing-fields::before, .woocommerce .woocommerce-billing-fields::after,
.woocommerce .woocommerce-shipping-fields::before,
.woocommerce .woocommerce-shipping-fields::after, .woocommerce-page .woocommerce-billing-fields::before, .woocommerce-page .woocommerce-billing-fields::after,
.woocommerce-page .woocommerce-shipping-fields::before,
.woocommerce-page .woocommerce-shipping-fields::after {
  content: " ";
  display: table;
}
.woocommerce .woocommerce-billing-fields::after,
.woocommerce .woocommerce-shipping-fields::after, .woocommerce-page .woocommerce-billing-fields::after,
.woocommerce-page .woocommerce-shipping-fields::after {
  clear: both;
}
.woocommerce .woocommerce-terms-and-conditions, .woocommerce-page .woocommerce-terms-and-conditions {
  margin-bottom: 1.618em;
  padding: 1.618em;
}
.woocommerce .woocommerce-oembed, .woocommerce-page .woocommerce-oembed {
  position: relative;
}

.woocommerce-account .woocommerce-MyAccount-navigation {
  float: left;
  width: 30%;
}
.woocommerce-account .woocommerce-MyAccount-content {
  float: right;
  width: 68%;
}

/**
 * RTL styles.
 */
.rtl .woocommerce .col2-set .col-1, .rtl .woocommerce-page .col2-set .col-1 {
  float: right;
}
.rtl .woocommerce .col2-set .col-2, .rtl .woocommerce-page .col2-set .col-2 {
  float: left;
}

body.single-product .lay-woocommerce-gallery.swiper-container {
  position: relative;
  --swiper-navigation-size: 30px;
  --swiper-theme-color: black;
}
body.single-product .lay-woocommerce-gallery.swiper-container .swiper-button-prev {
  padding-left: 20px;
  padding-right: 20px;
  left: 0;
}
body.single-product .lay-woocommerce-gallery.swiper-container .swiper-button-next {
  padding-left: 20px;
  padding-right: 20px;
  right: 0;
}
body.single-product .lay-woocommerce-sticky .summary {
  position: sticky;
}
body.single-product #lay-woocommerce .summary {
  float: left;
}
body.single-product .lay-woocommerce-gallery {
  float: left;
}
body.single-product .lay-woocommerce-gallery img {
  width: 100%;
}
body.single-product .lay-woocommerce-single-product-wrap:after {
  content: "";
  display: table;
  clear: both;
}

.lay-woocommerce-product-tab {
  margin-top: 35px;
}

.variations > div {
  margin-bottom: 20px;
}

.lay-woocommerce-single-product-wrap {
  width: 100%;
  max-width: 1920px;
  margin-left: auto;
  margin-right: auto;
}

.swiper-button-next, .swiper-button-prev {
  display: none !important;
}

.lay-woocommerce-single-product-wrap.carousel .swiper-button-next, .lay-woocommerce-single-product-wrap.carousel .swiper-button-prev {
  display: flex !important;
}

body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.one_image_per_row .lay-woocommerce-gallery {
  width: 48.9%;
  display: inline-block;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.one_image_per_row .lay-woocommerce-gallery div {
  width: 100%;
  display: block;
  margin-bottom: 2vw;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.one_image_per_row .lay-woocommerce-gallery div:last-child {
  margin-bottom: 0;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.one_image_per_row .lay-woocommerce-gallery .swiper-wrapper {
  margin-bottom: 0 !important;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.one_image_per_row .lay-woocommerce-gallery .lay-woocommerce-gallery.swiper-container {
  position: relative;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.one_image_per_row .lay-woocommerce-gallery .lay-woocommerce-gallery.swiper-container .swiper-pagination {
  display: none !important;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.one_image_per_row .lay-woocommerce-gallery .lay-woocommerce-gallery.swiper-container .swiper-wrapper {
  display: block !important;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.one_image_per_row .lay-woocommerce-gallery .swiper-pagination {
  display: none;
}

body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .swiper-wrapper {
  margin-bottom: 0 !important;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery.swiper-container {
  position: relative;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery.swiper-container .swiper-pagination {
  display: none !important;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery.swiper-container .swiper-wrapper {
  display: block !important;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .swiper-pagination {
  display: none;
}

body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery {
  width: 48.9%;
  display: inline-block;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery div {
  width: 100%;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery div:last-child {
  margin-bottom: 0;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery .swiper-wrapper {
  margin-bottom: 0 !important;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery .swiper-container.lay-woocommerce-gallery {
  position: relative;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery .lay-woocommerce-gallery img {
  width: 100%;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery .swiper-wrapper {
  cursor: grab;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery .swiper-slide {
  box-sizing: border-box;
  width: 100%;
}
body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.carousel .lay-woocommerce-gallery .swiper-pagination-bullets {
  margin-top: 9px;
}

@media (min-width: 1025px) {
  .summary {
    width: 450px;
  }
  .summary > * {
    max-width: 450px;
  }
  body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery {
    width: 62vw;
    max-width: calc(100% - 450px);
    display: inline-block;
  }
  body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery .swiper-slide {
    width: calc(50% - 1vw);
    display: inline-block;
    margin-bottom: 2vw;
  }
  body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery .swiper-slide:nth-child(odd) {
    margin-right: 2vw;
  }
  body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery .swiper-slide:last-child {
    margin-bottom: 0;
  }
  body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery .swiper-slide:nth-last-child(2) {
    margin-bottom: 0;
  }
}
@media (max-width: 1024px) {
  .summary {
    width: 50%;
  }
  body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery {
    width: 48.9%;
    display: inline-block;
  }
  body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery .swiper-slide {
    width: 100%;
    display: block;
    margin-bottom: 2vw;
  }
  body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery .swiper-slide:last-child {
    margin-bottom: 0;
  }
  body.single-product #lay-woocommerce .lay-woocommerce-single-product-wrap.two_images_per_row .lay-woocommerce-gallery .swiper-slide:last-child {
    margin-bottom: 0;
  }
}
.woocommerce-store-notice {
  position: relative;
  padding: 10px 35px;
  box-sizing: border-box;
}

body.lay-woocommerce-show-store-notice .sitetitle.position-top.is-fixed {
  position: absolute;
}
body.lay-woocommerce-show-store-notice .laynav.position-top.is-fixed {
  position: absolute;
}
body.lay-woocommerce-show-store-notice .navbar.position-top.is-fixed {
  position: absolute;
}

.woocommerce-message::before,
.woocommerce-info::before {
  color: black !important;
}

.woocommerce-message,
.woocommerce-info,
.woocommerce-error {
  color: black !important;
}

body.lay-woocommerce-show-store-notice .woocommerce-store-notice,
body.lay-woocommerce-show-store-notice p.demo_store {
  display: block !important;
}

body.lay-woocommerce-hide-store-notice .woocommerce-store-notice,
body.lay-woocommerce-hide-store-notice p.demo_store {
  display: none !important;
}

body.lay-woocommerce-store-notice-scrolled-down.lay-woocommerce-show-store-notice .sitetitle.position-top.is-fixed {
  position: fixed;
  margin-top: 0 !important;
}
body.lay-woocommerce-store-notice-scrolled-down.lay-woocommerce-show-store-notice .laynav.position-top.is-fixed {
  position: fixed;
  margin-top: 0 !important;
}
body.lay-woocommerce-store-notice-scrolled-down.lay-woocommerce-show-store-notice .navbar.position-top.is-fixed {
  position: fixed;
  margin-top: 0 !important;
}

.woocommerce-notices-wrapper {
  bottom: 20px;
}

.woocommerce-notices-wrapper div:last-child {
  margin-bottom: 0 !important;
}

.woocommerce form .form-row-first, .woocommerce form .form-row-last, .woocommerce-page form .form-row-first, .woocommerce-page form .form-row-last {
  width: calc(50% - 15px) !important;
}

#lay-woocommerce .checkout h3 {
  line-height: 1;
  margin-bottom: 43px;
  margin-top: 43px;
}

.xoo-wsc-container .xoo-wsc-qty-price {
  position: relative;
}
.xoo-wsc-container .xoo-wsc-qty-price > span:last-child {
  left: 6em;
  position: absolute;
}
.xoo-wsc-container .xoo-wsc-pprice {
  position: relative;
}
.xoo-wsc-container .xoo-wsc-pprice > .woocommerce-Price-amount {
  position: absolute;
  left: 6em;
}
.xoo-wsc-container .xoo-wsc-smr-ptotal {
  position: relative;
}
.xoo-wsc-container .xoo-wsc-smr-ptotal .woocommerce-Price-amount {
  position: absolute;
  left: 6em;
}
';