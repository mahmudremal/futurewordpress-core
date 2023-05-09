/**
 * Frontend Script.
 * 
 * @package FutureWordPressProjectCore
 */
 import Swal from "sweetalert2";
( function ( $ ) {
	class FutureWordPress_Frontend {
		constructor() {
			this.ajaxNonce = fwpSiteConfig?.ajax_nonce ?? '';
			this.ajaxUrl = fwpSiteConfig?.ajaxUrl ?? '';this.config = fwpSiteConfig;
			this.lastAjax	 = false;this.profile	 = fwpSiteConfig?.profile ?? false;
			var i18n = fwpSiteConfig?.i18n ?? {};this.noToast	 = true;
			this.i18n = {
				are_u_sure								: 'Are you sure?',
				...i18n
			}
			this.setup_hooks();
		}
		setup_hooks() {
			this.setup_toast();
			this.setup_events();
			this.setup_tawkto();
		}
		setup_toast() {
			this.Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: function didOpen(toast) {
					toast.addEventListener('mouseenter', Swal.stopTimer);
					toast.addEventListener('mouseleave', Swal.resumeTimer);
				}
			});
		}
		setup_events() {
			document.body.addEventListener('reload-page', function () {
				location.reload();
			});
		}
		sendToServer( data ) {
			
			var i = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
			var thisClass = this;
			var message;
			$.ajax({
				url: thisClass.ajaxUrl,
				type: "POST",
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				success: function success(json) {
					thisClass.lastAjax = json;
					message = json.data.message ? json.data.message : json.data;

					if (json.success) {
						if (typeof message === 'string') {
							if (thisClass.noToast) {
								Swal.fire({
									position: 'center',
									icon: 'success',
									text: message,
									showConfirmButton: false,
									timer: 3000
								});
							} else {
								thisClass.Toast.fire({
									title: message,
									icon: 'info'
								});
							}
						}

						if (i) {
							i.classList.remove('fa-spinner', 'fa-spin');
							i.classList.add('fa-check');
						}
					} else {
						if (typeof message === 'string') {
							if (thisClass.noToast) {
								Swal.fire({
									position: 'center',
									icon: 'error',
									text: message,
									showConfirmButton: false,
									timer: 3000
								});
							} else {
								thisClass.Toast.fire({
									title: message,
									icon: 'warn'
								});
							}
						}
						if (i) {
							i.classList.remove('fa-spinner', 'fa-spin');
							i.classList.add('fa-times');
						}
					}

					if (json.data.hooks) {
						json.data.hooks.forEach(function (hook) {
							document.body.dispatchEvent(new Event(hook));
						});
					}
				},
				error: function error(err) {
					console.log(err.responseText);
					thisClass.Toast.fire({
						title: err.responseText,
						icon: 'alert'
					});
					if (i) {
						i.classList.remove('fa-spinner', 'fa-spin');
						i.classList.add('fa-times');
					}
				}
			});
		}
		setup_tawkto() {
			if( ! this.config?.tawkalw??false ) {return;}
			var tawk = this.config?.tawkid??'';
			if( tawk == '' ) {return;}
			var Tawk_API = Tawk_API || {},
				Tawk_LoadStart = new Date();
			var s1 = document.createElement("script"),
					s0 = document.getElementsByTagName("script")[0];
			s1.async = true;s1.charset = 'UTF-8';
			s1.src = 'https://embed.tawk.to/' + tawk + '/default';
			s1.setAttribute('crossorigin', '*');
			s0.parentNode.insertBefore(s1, s0);
			setTimeout(function () {
				var theInterval = setInterval(function () {
					var myIframes = document.querySelectorAll('iframe.open');
					myIframes.forEach(function (myIframe, myIframesI) {
						var iframeDoc = myIframe.contentDocument || myIframe.contentWindow.document;

						if (iframeDoc) {
							var elementsToRemove = iframeDoc.querySelectorAll('.tawk-branding[id]');

							if (elementsToRemove && elementsToRemove.length >= 1) {
								myIframe.style.bottom = '40px !important';
								elementsToRemove.forEach(function (elementToRemove, elementToRemoveI) {
									// elementToRemove.style.display = 'none';
									elementToRemove.parentNode.removeChild(elementToRemove);
								});
								var button = iframeDoc.querySelector('.tawk-dropdown.tawk-toolbar-menu > .tawk-button');

								if (button) {
									button.addEventListener('click', function (e) {
										setTimeout(function () {
											var elementToRemove = iframeDoc.querySelector('.tawk-dropdown-menu.tawk-dropdown-menu-right > div > .tawk-button:last-child');
											elementToRemove.parentNode.removeChild(elementToRemove);
										}, 100);
									});
									clearInterval(theInterval);
									// console.log('Interval cleared');
								} else {
									// console.log('Widget Buttons not found');
								}
								var style, css = '.tawk-branding[id], .tawk-dropdown-menu.tawk-dropdown-menu-right > div > .tawk-button:last-child {display: none;}';
								style = document.createElement('style');
								style.innerHTML = css;
								iframeDoc.head.appendChild(style);
							} else {
								// console.log('Widget Elements not found');
							}
						} else {
							// console.log('Widget not found');
						}
					});
				}, 1000);
			}, 2000 );
			var twkInterval = setInterval(() => {
				document.querySelectorAll( '.tawkto_chattoggle' ).forEach( (el, ei) => {
					el.addEventListener( 'click', (e) => {
						e.preventDefault();
						if( typeof Tawk_API === 'undefined' && typeof window.Tawk_API === 'object' ) {var Tawk_API = window.Tawk_API;}
						if( typeof Tawk_API === 'undefined' ) {return;}
						if( typeof Tawk_API === 'object' && typeof Tawk_API.maximize === 'function' ) {
							if( Tawk_API.isChatMaximized() ) {
								Tawk_API.minimize();
							} else {
								Tawk_API.maximize();
							}
						}
					} );
					clearInterval( twkInterval );
				} );
			}, 3000 );
		}
	}
	new FutureWordPress_Frontend();
} )( jQuery );