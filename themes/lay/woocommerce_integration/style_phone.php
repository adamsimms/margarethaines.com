<?php
return
'
.woocommerce #main p {
  font-size: 16px !important;
  letter-spacing: 0.02em;
  color: black !important;
  font-weight: 100 !important;
  line-height: 1.2 !important;
  font-family: HelveticaNeue, Helvetica, sans-serif, -apple-system !important;
}

.woocommerce #main {
  font-size: 16px !important;
  letter-spacing: 0.02em;
  color: black !important;
  font-weight: 100 !important;
  line-height: 1.2 !important;
  font-family: HelveticaNeue, Helvetica, sans-serif, -apple-system !important;
}

.mobile-nav .laycart {
  display: none;
}

.woocommerce-store-notice {
  display: none !important;
}

body.mobile_burger_style_new .lay-cart-icon-wrap {
  margin-top: 1px;
}

.lay-cart-icon-wrap {
  display: inline-block;
  z-index: 31;
  box-sizing: border-box;
  cursor: pointer;
  font-size: 12px;
  font-family: sans-serif;
  font-size: 12px;
}

.lay-cart-icon-wrap:before {
  font-family: "icomoon" !important;
  speak: never;
  font-style: normal;
  font-weight: normal;
  font-variant: normal;
  text-transform: none;
  line-height: 1;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  content: "\e900";
  font-size: 20px;
  margin-right: 2px;
}

.xoo-wsc-container, .xoo-wsc-slider {
  width: 100% !important;
  max-width: none !important;
}

.xoo-wsc-container, .xoo-wsc-slider {
  right: -100% !important;
  transform: translateX(0);
  transition: transform 500ms cubic-bezier(0.52, 0.16, 0.24, 1);
}

.xoo-wsc-cart-active .xoo-wsc-container,
.xoo-wsc-slider-active .xoo-wsc-slider {
  transform: translateX(-100%);
}

body.single-product #lay-woocommerce {
  padding-left: 0;
  padding-right: 0;
}

.lay-woocommerce-product-tab {
  margin-top: 40px;
}

body.single-product .lay-no-variations .lay-woocommerce-product-tab {
  max-width: 100%;
  width: 100%;
}
body.single-product .lay-variations-count-1 .lay-woocommerce-product-tab {
  max-width: 100%;
  width: 100%;
}
body.single-product .lay-variations-count-more-than-1 .lay-woocommerce-product-tab {
  max-width: 100%;
}
body.single-product .single_variation_wrap.lay-variations-count-more-than-1 .lay-variable-products-select-container > div {
  margin-bottom: 20px;
}
body.single-product .single_variation_wrap.lay-variations-count-more-than-1 .lay-woocommerce-qty-wrap {
  margin-right: 0;
}
body.single-product .single_variation_wrap.lay-variations-count-more-than-1 .woocommerce-variation > p {
  margin-bottom: 20px;
}
body.single-product .summary {
  padding-top: 20px;
}
body.single-product .lay-woocommerce-summary-inner > .price {
  margin-top: 25px;
  margin-bottom: 25px;
}

.swiper-container.lay-woocommerce-gallery {
  position: relative;
  --swiper-navigation-size: 30px;
  --swiper-theme-color: black;
}
.swiper-container.lay-woocommerce-gallery .swiper-button-prev {
  padding-left: 30px;
  padding-right: 30px;
  left: 0;
}
.swiper-container.lay-woocommerce-gallery .swiper-button-next {
  padding-right: 30px;
  padding-left: 30px;
  right: 0;
}

.lay-woocommerce-gallery img {
  width: 100%;
}

.lay-woocommerce-gallery-container-initialized .swiper-wrapper {
  cursor: grab;
}

.lay-woocommerce-gallery .swiper-slide {
  box-sizing: border-box;
}
.lay-woocommerce-gallery .swiper-pagination-bullets {
  margin-top: 9px;
}

#lay-woocommerce .lay-woocommerce-related-products-scroller {
  overflow-x: scroll;
}
#lay-woocommerce .lay-woocommerce-related-products-scroller::-webkit-scrollbar {
  display: none;
}
#lay-woocommerce .upsells.products ul,
#lay-woocommerce .related.products ul {
  margin-bottom: 0;
}
#lay-woocommerce .upsells.products ul li,
#lay-woocommerce .related.products ul li {
  width: 220px;
  margin: 0 0 0 0;
}
#lay-woocommerce .upsells.products h2,
#lay-woocommerce .related.products h2 {
  margin-top: 52px;
  margin-bottom: 15px;
}

.lay-woocommerce-product-tab .lay-woocommerce-tab-title {
  padding-left: 0;
}

.single_add_to_cart_button {
  width: 100%;
}

.lay-variations-count-more-than-1 .lay-woocommerce-variations-select {
  width: calc(50% - 10px) !important;
  display: inline-block;
}
.lay-variations-count-more-than-1 .lay-woocommerce-variations-select:nth-child(even) {
  margin-left: 20px;
}

.woocommerce #main .woocommerce-message,
.woocommerce #main .woocommerce-info,
.woocommerce #main .woocommerce-error {
  font-size: 12px !important;
  letter-spacing: 0.02em !important;
}

.woocommerce-message,
.woocommerce-info,
.woocommerce-error {
  left: 0 !important;
  right: 0 !important;
  border-radius: 0 !important;
  width: 100% !important;
  margin: 0 0 0 0 !important;
  z-index: 0 !important;
  box-shadow: none !important;
  border-top: 0 !important;
  background: white !important;
  border-bottom: 1px solid #e0e0e0;
}

.woocommerce-message,
.woocommerce-info,
.woocommerce-error {
  position: relative !important;
  padding: 8px 5px 8px 5px !important;
  top: 0 !important;
  display: inline-block !important;
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

.woocommerce-store-notice {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  padding: 10px 40px;
  box-sizing: border-box;
}

body.lay-woocommerce-show-store-notice .woocommerce-store-notice,
body.lay-woocommerce-show-store-notice p.demo_store {
  display: inline-block !important;
}

body.lay-woocommerce-hide-store-notice .woocommerce-store-notice,
body.lay-woocommerce-hide-store-notice p.demo_store {
  display: none !important;
}

body.lay-woocommerce-show-store-notice .mobile-title.is-fixed {
  position: absolute;
}
body.lay-woocommerce-show-store-notice .navbar.is-fixed {
  position: absolute;
}
body.lay-woocommerce-show-store-notice .lay-mobile-icons-wrap.is-fixed {
  position: absolute;
}

body.lay-woocommerce-store-notice-scrolled-down.lay-woocommerce-show-store-notice .mobile-title.is-fixed {
  position: fixed;
  margin-top: 0 !important;
}
body.lay-woocommerce-store-notice-scrolled-down.lay-woocommerce-show-store-notice .navbar.is-fixed {
  position: fixed;
  margin-top: 0 !important;
}
body.lay-woocommerce-store-notice-scrolled-down.lay-woocommerce-show-store-notice .lay-mobile-icons-wrap.is-fixed {
  position: fixed;
  margin-top: 0 !important;
}

.woocommerce-notices-wrapper {
  bottom: 10px;
}

.woocommerce-notices-wrapper {
  width: calc(100% - 20px);
}
.woocommerce-notices-wrapper div:last-child {
  margin-bottom: 0 !important;
}

.woocommerce-message,
.woocommerce-info,
.woocommerce-error {
  width: 100% !important;
  box-sizing: border-box;
}
.woocommerce-message .button,
.woocommerce-info .button,
.woocommerce-error .button {
  white-space: nowrap;
}

.woocommerce form .form-row-first, .woocommerce form .form-row-last, .woocommerce-page form .form-row-first, .woocommerce-page form .form-row-last {
  width: 100% !important;
}

#lay-woocommerce .checkout h3 {
  line-height: 1;
  margin-bottom: 27px;
  margin-top: 27px;
}

.xoo-wsc-container .xoo-wsc-qty-price {
  position: relative;
}
.xoo-wsc-container .xoo-wsc-qty-price > span:last-child {
  left: 4em;
  position: absolute;
}
.xoo-wsc-container .xoo-wsc-pprice {
  position: relative;
}
.xoo-wsc-container .xoo-wsc-pprice > .woocommerce-Price-amount {
  position: absolute;
  left: 4em;
}
.xoo-wsc-container .xoo-wsc-smr-ptotal {
  position: relative;
}
.xoo-wsc-container .xoo-wsc-smr-ptotal .woocommerce-Price-amount {
  position: absolute;
  left: 4em;
}
';