(window.webpackJsonp_post_selector_two_galerie=window.webpackJsonp_post_selector_two_galerie||[]).push([[1],{15:function(e,t,r){}}]),function(e){function t(t){for(var n,i,a=t[0],c=t[1],u=t[2],p=0,f=[];p<a.length;p++)i=a[p],Object.prototype.hasOwnProperty.call(o,i)&&o[i]&&f.push(o[i][0]),o[i]=0;for(n in c)Object.prototype.hasOwnProperty.call(c,n)&&(e[n]=c[n]);for(l&&l(t);f.length;)f.shift()();return s.push.apply(s,u||[]),r()}function r(){for(var e,t=0;t<s.length;t++){for(var r=s[t],n=!0,a=1;a<r.length;a++){var c=r[a];0!==o[c]&&(n=!1)}n&&(s.splice(t--,1),e=i(i.s=r[0]))}return e}var n={},o={0:0},s=[];function i(t){if(n[t])return n[t].exports;var r=n[t]={i:t,l:!1,exports:{}};return e[t].call(r.exports,r,r.exports,i),r.l=!0,r.exports}i.m=e,i.c=n,i.d=function(e,t,r){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(i.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(r,n,function(t){return e[t]}.bind(null,n));return r},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="";var a=window.webpackJsonp_post_selector_two_galerie=window.webpackJsonp_post_selector_two_galerie||[],c=a.push.bind(a);a.push=t,a=a.slice();for(var u=0;u<a.length;u++)t(a[u]);var l=c;s.push([35,1]),r()}([function(e,t){e.exports=window.wp.element},function(e,t){e.exports=window.wp.i18n},function(e,t,r){"use strict";var n=r(6),o=Object.prototype.toString;function s(e){return"[object Array]"===o.call(e)}function i(e){return void 0===e}function a(e){return null!==e&&"object"==typeof e}function c(e){if("[object Object]"!==o.call(e))return!1;var t=Object.getPrototypeOf(e);return null===t||t===Object.prototype}function u(e){return"[object Function]"===o.call(e)}function l(e,t){if(null!=e)if("object"!=typeof e&&(e=[e]),s(e))for(var r=0,n=e.length;r<n;r++)t.call(null,e[r],r,e);else for(var o in e)Object.prototype.hasOwnProperty.call(e,o)&&t.call(null,e[o],o,e)}e.exports={isArray:s,isArrayBuffer:function(e){return"[object ArrayBuffer]"===o.call(e)},isBuffer:function(e){return null!==e&&!i(e)&&null!==e.constructor&&!i(e.constructor)&&"function"==typeof e.constructor.isBuffer&&e.constructor.isBuffer(e)},isFormData:function(e){return"undefined"!=typeof FormData&&e instanceof FormData},isArrayBufferView:function(e){return"undefined"!=typeof ArrayBuffer&&ArrayBuffer.isView?ArrayBuffer.isView(e):e&&e.buffer&&e.buffer instanceof ArrayBuffer},isString:function(e){return"string"==typeof e},isNumber:function(e){return"number"==typeof e},isObject:a,isPlainObject:c,isUndefined:i,isDate:function(e){return"[object Date]"===o.call(e)},isFile:function(e){return"[object File]"===o.call(e)},isBlob:function(e){return"[object Blob]"===o.call(e)},isFunction:u,isStream:function(e){return a(e)&&u(e.pipe)},isURLSearchParams:function(e){return"undefined"!=typeof URLSearchParams&&e instanceof URLSearchParams},isStandardBrowserEnv:function(){return("undefined"==typeof navigator||"ReactNative"!==navigator.product&&"NativeScript"!==navigator.product&&"NS"!==navigator.product)&&"undefined"!=typeof window&&"undefined"!=typeof document},forEach:l,merge:function e(){var t={};function r(r,n){c(t[n])&&c(r)?t[n]=e(t[n],r):c(r)?t[n]=e({},r):s(r)?t[n]=r.slice():t[n]=r}for(var n=0,o=arguments.length;n<o;n++)l(arguments[n],r);return t},extend:function(e,t,r){return l(t,(function(t,o){e[o]=r&&"function"==typeof t?n(t,r):t})),e},trim:function(e){return e.trim?e.trim():e.replace(/^\s+|\s+$/g,"")},stripBOM:function(e){return 65279===e.charCodeAt(0)&&(e=e.slice(1)),e}}},function(e,t){e.exports=window.wp.components},function(e,t){e.exports=window.wp.blockEditor},function(e,t,r){"use strict";(function(t){var n=r(2),o=r(22),s=r(8),i={"Content-Type":"application/x-www-form-urlencoded"};function a(e,t){!n.isUndefined(e)&&n.isUndefined(e["Content-Type"])&&(e["Content-Type"]=t)}var c,u={transitional:{silentJSONParsing:!0,forcedJSONParsing:!0,clarifyTimeoutError:!1},adapter:(("undefined"!=typeof XMLHttpRequest||void 0!==t&&"[object process]"===Object.prototype.toString.call(t))&&(c=r(9)),c),transformRequest:[function(e,t){return o(t,"Accept"),o(t,"Content-Type"),n.isFormData(e)||n.isArrayBuffer(e)||n.isBuffer(e)||n.isStream(e)||n.isFile(e)||n.isBlob(e)?e:n.isArrayBufferView(e)?e.buffer:n.isURLSearchParams(e)?(a(t,"application/x-www-form-urlencoded;charset=utf-8"),e.toString()):n.isObject(e)||t&&"application/json"===t["Content-Type"]?(a(t,"application/json"),function(e,t,r){if(n.isString(e))try{return(0,JSON.parse)(e),n.trim(e)}catch(e){if("SyntaxError"!==e.name)throw e}return(0,JSON.stringify)(e)}(e)):e}],transformResponse:[function(e){var t=this.transitional,r=t&&t.silentJSONParsing,o=t&&t.forcedJSONParsing,i=!r&&"json"===this.responseType;if(i||o&&n.isString(e)&&e.length)try{return JSON.parse(e)}catch(e){if(i){if("SyntaxError"===e.name)throw s(e,this,"E_JSON_PARSE");throw e}}return e}],timeout:0,xsrfCookieName:"XSRF-TOKEN",xsrfHeaderName:"X-XSRF-TOKEN",maxContentLength:-1,maxBodyLength:-1,validateStatus:function(e){return e>=200&&e<300},headers:{common:{Accept:"application/json, text/plain, */*"}}};n.forEach(["delete","get","head"],(function(e){u.headers[e]={}})),n.forEach(["post","put","patch"],(function(e){u.headers[e]=n.merge(i)})),e.exports=u}).call(this,r(21))},function(e,t,r){"use strict";e.exports=function(e,t){return function(){for(var r=new Array(arguments.length),n=0;n<r.length;n++)r[n]=arguments[n];return e.apply(t,r)}}},function(e,t,r){"use strict";var n=r(2);function o(e){return encodeURIComponent(e).replace(/%3A/gi,":").replace(/%24/g,"$").replace(/%2C/gi,",").replace(/%20/g,"+").replace(/%5B/gi,"[").replace(/%5D/gi,"]")}e.exports=function(e,t,r){if(!t)return e;var s;if(r)s=r(t);else if(n.isURLSearchParams(t))s=t.toString();else{var i=[];n.forEach(t,(function(e,t){null!=e&&(n.isArray(e)?t+="[]":e=[e],n.forEach(e,(function(e){n.isDate(e)?e=e.toISOString():n.isObject(e)&&(e=JSON.stringify(e)),i.push(o(t)+"="+o(e))})))})),s=i.join("&")}if(s){var a=e.indexOf("#");-1!==a&&(e=e.slice(0,a)),e+=(-1===e.indexOf("?")?"?":"&")+s}return e}},function(e,t,r){"use strict";e.exports=function(e,t,r,n,o){return e.config=t,r&&(e.code=r),e.request=n,e.response=o,e.isAxiosError=!0,e.toJSON=function(){return{message:this.message,name:this.name,description:this.description,number:this.number,fileName:this.fileName,lineNumber:this.lineNumber,columnNumber:this.columnNumber,stack:this.stack,config:this.config,code:this.code}},e}},function(e,t,r){"use strict";var n=r(2),o=r(23),s=r(24),i=r(7),a=r(25),c=r(28),u=r(29),l=r(10);e.exports=function(e){return new Promise((function(t,r){var p=e.data,f=e.headers,d=e.responseType;n.isFormData(p)&&delete f["Content-Type"];var h=new XMLHttpRequest;if(e.auth){var m=e.auth.username||"",g=e.auth.password?unescape(encodeURIComponent(e.auth.password)):"";f.Authorization="Basic "+btoa(m+":"+g)}var b=a(e.baseURL,e.url);function v(){if(h){var n="getAllResponseHeaders"in h?c(h.getAllResponseHeaders()):null,s={data:d&&"text"!==d&&"json"!==d?h.response:h.responseText,status:h.status,statusText:h.statusText,headers:n,config:e,request:h};o(t,r,s),h=null}}if(h.open(e.method.toUpperCase(),i(b,e.params,e.paramsSerializer),!0),h.timeout=e.timeout,"onloadend"in h?h.onloadend=v:h.onreadystatechange=function(){h&&4===h.readyState&&(0!==h.status||h.responseURL&&0===h.responseURL.indexOf("file:"))&&setTimeout(v)},h.onabort=function(){h&&(r(l("Request aborted",e,"ECONNABORTED",h)),h=null)},h.onerror=function(){r(l("Network Error",e,null,h)),h=null},h.ontimeout=function(){var t="timeout of "+e.timeout+"ms exceeded";e.timeoutErrorMessage&&(t=e.timeoutErrorMessage),r(l(t,e,e.transitional&&e.transitional.clarifyTimeoutError?"ETIMEDOUT":"ECONNABORTED",h)),h=null},n.isStandardBrowserEnv()){var y=(e.withCredentials||u(b))&&e.xsrfCookieName?s.read(e.xsrfCookieName):void 0;y&&(f[e.xsrfHeaderName]=y)}"setRequestHeader"in h&&n.forEach(f,(function(e,t){void 0===p&&"content-type"===t.toLowerCase()?delete f[t]:h.setRequestHeader(t,e)})),n.isUndefined(e.withCredentials)||(h.withCredentials=!!e.withCredentials),d&&"json"!==d&&(h.responseType=e.responseType),"function"==typeof e.onDownloadProgress&&h.addEventListener("progress",e.onDownloadProgress),"function"==typeof e.onUploadProgress&&h.upload&&h.upload.addEventListener("progress",e.onUploadProgress),e.cancelToken&&e.cancelToken.promise.then((function(e){h&&(h.abort(),r(e),h=null)})),p||(p=null),h.send(p)}))}},function(e,t,r){"use strict";var n=r(8);e.exports=function(e,t,r,o,s){var i=new Error(e);return n(i,t,r,o,s)}},function(e,t,r){"use strict";e.exports=function(e){return!(!e||!e.__CANCEL__)}},function(e,t,r){"use strict";var n=r(2);e.exports=function(e,t){t=t||{};var r={},o=["url","method","data"],s=["headers","auth","proxy","params"],i=["baseURL","transformRequest","transformResponse","paramsSerializer","timeout","timeoutMessage","withCredentials","adapter","responseType","xsrfCookieName","xsrfHeaderName","onUploadProgress","onDownloadProgress","decompress","maxContentLength","maxBodyLength","maxRedirects","transport","httpAgent","httpsAgent","cancelToken","socketPath","responseEncoding"],a=["validateStatus"];function c(e,t){return n.isPlainObject(e)&&n.isPlainObject(t)?n.merge(e,t):n.isPlainObject(t)?n.merge({},t):n.isArray(t)?t.slice():t}function u(o){n.isUndefined(t[o])?n.isUndefined(e[o])||(r[o]=c(void 0,e[o])):r[o]=c(e[o],t[o])}n.forEach(o,(function(e){n.isUndefined(t[e])||(r[e]=c(void 0,t[e]))})),n.forEach(s,u),n.forEach(i,(function(o){n.isUndefined(t[o])?n.isUndefined(e[o])||(r[o]=c(void 0,e[o])):r[o]=c(void 0,t[o])})),n.forEach(a,(function(n){n in t?r[n]=c(e[n],t[n]):n in e&&(r[n]=c(void 0,e[n]))}));var l=o.concat(s).concat(i).concat(a),p=Object.keys(e).concat(Object.keys(t)).filter((function(e){return-1===l.indexOf(e)}));return n.forEach(p,u),r}},function(e,t,r){"use strict";function n(e){this.message=e}n.prototype.toString=function(){return"Cancel"+(this.message?": "+this.message:"")},n.prototype.__CANCEL__=!0,e.exports=n},function(e,t,r){e.exports=r(16)},,function(e,t,r){"use strict";var n=r(2),o=r(6),s=r(17),i=r(12);function a(e){var t=new s(e),r=o(s.prototype.request,t);return n.extend(r,s.prototype,t),n.extend(r,t),r}var c=a(r(5));c.Axios=s,c.create=function(e){return a(i(c.defaults,e))},c.Cancel=r(13),c.CancelToken=r(32),c.isCancel=r(11),c.all=function(e){return Promise.all(e)},c.spread=r(33),c.isAxiosError=r(34),e.exports=c,e.exports.default=c},function(e,t,r){"use strict";var n=r(2),o=r(7),s=r(18),i=r(19),a=r(12),c=r(30),u=c.validators;function l(e){this.defaults=e,this.interceptors={request:new s,response:new s}}l.prototype.request=function(e){"string"==typeof e?(e=arguments[1]||{}).url=arguments[0]:e=e||{},(e=a(this.defaults,e)).method?e.method=e.method.toLowerCase():this.defaults.method?e.method=this.defaults.method.toLowerCase():e.method="get";var t=e.transitional;void 0!==t&&c.assertOptions(t,{silentJSONParsing:u.transitional(u.boolean,"1.0.0"),forcedJSONParsing:u.transitional(u.boolean,"1.0.0"),clarifyTimeoutError:u.transitional(u.boolean,"1.0.0")},!1);var r=[],n=!0;this.interceptors.request.forEach((function(t){"function"==typeof t.runWhen&&!1===t.runWhen(e)||(n=n&&t.synchronous,r.unshift(t.fulfilled,t.rejected))}));var o,s=[];if(this.interceptors.response.forEach((function(e){s.push(e.fulfilled,e.rejected)})),!n){var l=[i,void 0];for(Array.prototype.unshift.apply(l,r),l=l.concat(s),o=Promise.resolve(e);l.length;)o=o.then(l.shift(),l.shift());return o}for(var p=e;r.length;){var f=r.shift(),d=r.shift();try{p=f(p)}catch(e){d(e);break}}try{o=i(p)}catch(e){return Promise.reject(e)}for(;s.length;)o=o.then(s.shift(),s.shift());return o},l.prototype.getUri=function(e){return e=a(this.defaults,e),o(e.url,e.params,e.paramsSerializer).replace(/^\?/,"")},n.forEach(["delete","get","head","options"],(function(e){l.prototype[e]=function(t,r){return this.request(a(r||{},{method:e,url:t,data:(r||{}).data}))}})),n.forEach(["post","put","patch"],(function(e){l.prototype[e]=function(t,r,n){return this.request(a(n||{},{method:e,url:t,data:r}))}})),e.exports=l},function(e,t,r){"use strict";var n=r(2);function o(){this.handlers=[]}o.prototype.use=function(e,t,r){return this.handlers.push({fulfilled:e,rejected:t,synchronous:!!r&&r.synchronous,runWhen:r?r.runWhen:null}),this.handlers.length-1},o.prototype.eject=function(e){this.handlers[e]&&(this.handlers[e]=null)},o.prototype.forEach=function(e){n.forEach(this.handlers,(function(t){null!==t&&e(t)}))},e.exports=o},function(e,t,r){"use strict";var n=r(2),o=r(20),s=r(11),i=r(5);function a(e){e.cancelToken&&e.cancelToken.throwIfRequested()}e.exports=function(e){return a(e),e.headers=e.headers||{},e.data=o.call(e,e.data,e.headers,e.transformRequest),e.headers=n.merge(e.headers.common||{},e.headers[e.method]||{},e.headers),n.forEach(["delete","get","head","post","put","patch","common"],(function(t){delete e.headers[t]})),(e.adapter||i.adapter)(e).then((function(t){return a(e),t.data=o.call(e,t.data,t.headers,e.transformResponse),t}),(function(t){return s(t)||(a(e),t&&t.response&&(t.response.data=o.call(e,t.response.data,t.response.headers,e.transformResponse))),Promise.reject(t)}))}},function(e,t,r){"use strict";var n=r(2),o=r(5);e.exports=function(e,t,r){var s=this||o;return n.forEach(r,(function(r){e=r.call(s,e,t)})),e}},function(e,t){var r,n,o=e.exports={};function s(){throw new Error("setTimeout has not been defined")}function i(){throw new Error("clearTimeout has not been defined")}function a(e){if(r===setTimeout)return setTimeout(e,0);if((r===s||!r)&&setTimeout)return r=setTimeout,setTimeout(e,0);try{return r(e,0)}catch(t){try{return r.call(null,e,0)}catch(t){return r.call(this,e,0)}}}!function(){try{r="function"==typeof setTimeout?setTimeout:s}catch(e){r=s}try{n="function"==typeof clearTimeout?clearTimeout:i}catch(e){n=i}}();var c,u=[],l=!1,p=-1;function f(){l&&c&&(l=!1,c.length?u=c.concat(u):p=-1,u.length&&d())}function d(){if(!l){var e=a(f);l=!0;for(var t=u.length;t;){for(c=u,u=[];++p<t;)c&&c[p].run();p=-1,t=u.length}c=null,l=!1,function(e){if(n===clearTimeout)return clearTimeout(e);if((n===i||!n)&&clearTimeout)return n=clearTimeout,clearTimeout(e);try{n(e)}catch(t){try{return n.call(null,e)}catch(t){return n.call(this,e)}}}(e)}}function h(e,t){this.fun=e,this.array=t}function m(){}o.nextTick=function(e){var t=new Array(arguments.length-1);if(arguments.length>1)for(var r=1;r<arguments.length;r++)t[r-1]=arguments[r];u.push(new h(e,t)),1!==u.length||l||a(d)},h.prototype.run=function(){this.fun.apply(null,this.array)},o.title="browser",o.browser=!0,o.env={},o.argv=[],o.version="",o.versions={},o.on=m,o.addListener=m,o.once=m,o.off=m,o.removeListener=m,o.removeAllListeners=m,o.emit=m,o.prependListener=m,o.prependOnceListener=m,o.listeners=function(e){return[]},o.binding=function(e){throw new Error("process.binding is not supported")},o.cwd=function(){return"/"},o.chdir=function(e){throw new Error("process.chdir is not supported")},o.umask=function(){return 0}},function(e,t,r){"use strict";var n=r(2);e.exports=function(e,t){n.forEach(e,(function(r,n){n!==t&&n.toUpperCase()===t.toUpperCase()&&(e[t]=r,delete e[n])}))}},function(e,t,r){"use strict";var n=r(10);e.exports=function(e,t,r){var o=r.config.validateStatus;r.status&&o&&!o(r.status)?t(n("Request failed with status code "+r.status,r.config,null,r.request,r)):e(r)}},function(e,t,r){"use strict";var n=r(2);e.exports=n.isStandardBrowserEnv()?{write:function(e,t,r,o,s,i){var a=[];a.push(e+"="+encodeURIComponent(t)),n.isNumber(r)&&a.push("expires="+new Date(r).toGMTString()),n.isString(o)&&a.push("path="+o),n.isString(s)&&a.push("domain="+s),!0===i&&a.push("secure"),document.cookie=a.join("; ")},read:function(e){var t=document.cookie.match(new RegExp("(^|;\\s*)("+e+")=([^;]*)"));return t?decodeURIComponent(t[3]):null},remove:function(e){this.write(e,"",Date.now()-864e5)}}:{write:function(){},read:function(){return null},remove:function(){}}},function(e,t,r){"use strict";var n=r(26),o=r(27);e.exports=function(e,t){return e&&!n(t)?o(e,t):t}},function(e,t,r){"use strict";e.exports=function(e){return/^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(e)}},function(e,t,r){"use strict";e.exports=function(e,t){return t?e.replace(/\/+$/,"")+"/"+t.replace(/^\/+/,""):e}},function(e,t,r){"use strict";var n=r(2),o=["age","authorization","content-length","content-type","etag","expires","from","host","if-modified-since","if-unmodified-since","last-modified","location","max-forwards","proxy-authorization","referer","retry-after","user-agent"];e.exports=function(e){var t,r,s,i={};return e?(n.forEach(e.split("\n"),(function(e){if(s=e.indexOf(":"),t=n.trim(e.substr(0,s)).toLowerCase(),r=n.trim(e.substr(s+1)),t){if(i[t]&&o.indexOf(t)>=0)return;i[t]="set-cookie"===t?(i[t]?i[t]:[]).concat([r]):i[t]?i[t]+", "+r:r}})),i):i}},function(e,t,r){"use strict";var n=r(2);e.exports=n.isStandardBrowserEnv()?function(){var e,t=/(msie|trident)/i.test(navigator.userAgent),r=document.createElement("a");function o(e){var n=e;return t&&(r.setAttribute("href",n),n=r.href),r.setAttribute("href",n),{href:r.href,protocol:r.protocol?r.protocol.replace(/:$/,""):"",host:r.host,search:r.search?r.search.replace(/^\?/,""):"",hash:r.hash?r.hash.replace(/^#/,""):"",hostname:r.hostname,port:r.port,pathname:"/"===r.pathname.charAt(0)?r.pathname:"/"+r.pathname}}return e=o(window.location.href),function(t){var r=n.isString(t)?o(t):t;return r.protocol===e.protocol&&r.host===e.host}}():function(){return!0}},function(e,t,r){"use strict";var n=r(31),o={};["object","boolean","number","function","string","symbol"].forEach((function(e,t){o[e]=function(r){return typeof r===e||"a"+(t<1?"n ":" ")+e}}));var s={},i=n.version.split(".");function a(e,t){for(var r=t?t.split("."):i,n=e.split("."),o=0;o<3;o++){if(r[o]>n[o])return!0;if(r[o]<n[o])return!1}return!1}o.transitional=function(e,t,r){var o=t&&a(t);function i(e,t){return"[Axios v"+n.version+"] Transitional option '"+e+"'"+t+(r?". "+r:"")}return function(r,n,a){if(!1===e)throw new Error(i(n," has been removed in "+t));return o&&!s[n]&&(s[n]=!0,console.warn(i(n," has been deprecated since v"+t+" and will be removed in the near future"))),!e||e(r,n,a)}},e.exports={isOlderVersion:a,assertOptions:function(e,t,r){if("object"!=typeof e)throw new TypeError("options must be an object");for(var n=Object.keys(e),o=n.length;o-- >0;){var s=n[o],i=t[s];if(i){var a=e[s],c=void 0===a||i(a,s,e);if(!0!==c)throw new TypeError("option "+s+" must be "+c)}else if(!0!==r)throw Error("Unknown option "+s)}},validators:o}},function(e){e.exports=JSON.parse('{"_from":"axios@^0.21.1","_id":"axios@0.21.4","_inBundle":false,"_integrity":"sha512-ut5vewkiu8jjGBdqpM44XxjuCjq9LAKeHVmoVfHVzy8eHgxxq8SbAVQNovDA8mVi05kP0Ea/n/UzcSHcTJQfNg==","_location":"/axios","_phantomChildren":{},"_requested":{"type":"range","registry":true,"raw":"axios@^0.21.1","name":"axios","escapedName":"axios","rawSpec":"^0.21.1","saveSpec":null,"fetchSpec":"^0.21.1"},"_requiredBy":["/"],"_resolved":"https://registry.npmjs.org/axios/-/axios-0.21.4.tgz","_shasum":"c67b90dc0568e5c1cf2b0b858c43ba28e2eda575","_spec":"axios@^0.21.1","_where":"G:\\\\PHP-Projekte\\\\wiecker-web.de\\\\starter-testumgebung\\\\starter-wordpress\\\\plugins\\\\post-selector\\\\admin\\\\gutenberg\\\\galerie-data","author":{"name":"Matt Zabriskie"},"browser":{"./lib/adapters/http.js":"./lib/adapters/xhr.js"},"bugs":{"url":"https://github.com/axios/axios/issues"},"bundleDependencies":false,"bundlesize":[{"path":"./dist/axios.min.js","threshold":"5kB"}],"dependencies":{"follow-redirects":"^1.14.0"},"deprecated":false,"description":"Promise based HTTP client for the browser and node.js","devDependencies":{"coveralls":"^3.0.0","es6-promise":"^4.2.4","grunt":"^1.3.0","grunt-banner":"^0.6.0","grunt-cli":"^1.2.0","grunt-contrib-clean":"^1.1.0","grunt-contrib-watch":"^1.0.0","grunt-eslint":"^23.0.0","grunt-karma":"^4.0.0","grunt-mocha-test":"^0.13.3","grunt-ts":"^6.0.0-beta.19","grunt-webpack":"^4.0.2","istanbul-instrumenter-loader":"^1.0.0","jasmine-core":"^2.4.1","karma":"^6.3.2","karma-chrome-launcher":"^3.1.0","karma-firefox-launcher":"^2.1.0","karma-jasmine":"^1.1.1","karma-jasmine-ajax":"^0.1.13","karma-safari-launcher":"^1.0.0","karma-sauce-launcher":"^4.3.6","karma-sinon":"^1.0.5","karma-sourcemap-loader":"^0.3.8","karma-webpack":"^4.0.2","load-grunt-tasks":"^3.5.2","minimist":"^1.2.0","mocha":"^8.2.1","sinon":"^4.5.0","terser-webpack-plugin":"^4.2.3","typescript":"^4.0.5","url-search-params":"^0.10.0","webpack":"^4.44.2","webpack-dev-server":"^3.11.0"},"homepage":"https://axios-http.com","jsdelivr":"dist/axios.min.js","keywords":["xhr","http","ajax","promise","node"],"license":"MIT","main":"index.js","name":"axios","repository":{"type":"git","url":"git+https://github.com/axios/axios.git"},"scripts":{"build":"NODE_ENV=production grunt build","coveralls":"cat coverage/lcov.info | ./node_modules/coveralls/bin/coveralls.js","examples":"node ./examples/server.js","fix":"eslint --fix lib/**/*.js","postversion":"git push && git push --tags","preversion":"npm test","start":"node ./sandbox/server.js","test":"grunt test","version":"npm run build && grunt version && git add -A dist && git add CHANGELOG.md bower.json package.json"},"typings":"./index.d.ts","unpkg":"dist/axios.min.js","version":"0.21.4"}')},function(e,t,r){"use strict";var n=r(13);function o(e){if("function"!=typeof e)throw new TypeError("executor must be a function.");var t;this.promise=new Promise((function(e){t=e}));var r=this;e((function(e){r.reason||(r.reason=new n(e),t(r.reason))}))}o.prototype.throwIfRequested=function(){if(this.reason)throw this.reason},o.source=function(){var e;return{token:new o((function(t){e=t})),cancel:e}},e.exports=o},function(e,t,r){"use strict";e.exports=function(e){return function(t){return e.apply(null,t)}}},function(e,t,r){"use strict";e.exports=function(e){return"object"==typeof e&&!0===e.isAxiosError}},function(e,t,r){"use strict";r.r(t);var n=r(0),o=(r(15),r(14)),s=r.n(o),i=r(1);const{Component:a}=wp.element,c=Object(n.createElement)("svg",{width:20,height:20},Object(n.createElement)("path",{d:"M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"}));class u extends a{constructor(e){super(...arguments),this.props=e,this.state={selectGalerie:[]},this.galerieSelectChange=this.galerieSelectChange.bind(this)}componentDidMount(){var e=this;s.a.get(PS2RestObj.url+"get-galerie-data",{headers:{"content-type":"application/json","X-WP-Nonce":PS2RestObj.nonce}}).then((function(){let{data:t={}}=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};e.setState({selectGalerie:t.select})}))}galerieSelectChange(e){this.props.updateSelectedGalerie(this.props.selectedGalerie=e)}render(){return Object(n.createElement)("div",null,Object(n.createElement)("div",{className:"settings-form-flex-column"},Object(n.createElement)("label",{className:"form-label",htmlFor:"GalerieSelect"},c," ",Object(n.createElement)("b",{className:"b-fett"},Object(i.__)("Gallery","post-selector"))," ",Object(i.__)("select","post-selector"),": "),Object(n.createElement)("select",{className:"form-select",name:"options",id:"GalerieSelect",onChange:e=>this.galerieSelectChange(e.target.value)},Object(n.createElement)("option",{value:""}," ",Object(i.__)("select","post-selector")," ..."),this.state.selectGalerie?this.state.selectGalerie.map((e,t)=>Object(n.createElement)("option",{key:t,value:e.id,selected:e.id==this.props.selectedGalerie},e.name)):Object(n.createElement)("option",{value:""},Object(i.__)("loading","post-selector")))))}}var l=r(4),p=r(3);const{Component:f}=wp.element,{registerBlockType:d}=wp.blocks,h=Object(n.createElement)("svg",{width:20,height:20},Object(n.createElement)("path",{d:"M14.002 13a2 2 0 0 1-2 2h-10a2 2 0 0 1-2-2V5A2 2 0 0 1 2 3a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-1.998 2zM14 2H4a1 1 0 0 0-1 1h9.002a2 2 0 0 1 2 2v7A1 1 0 0 0 15 11V3a1 1 0 0 0-1-1zM2.002 4a1 1 0 0 0-1 1v8l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71a.5.5 0 0 1 .577-.094l1.777 1.947V5a1 1 0 0 0-1-1h-10z"}));d("hupa/post-selector-two-galerie",{title:Object(i.__)("Post selector 2 gallery","post-selector"),icon:h,class:"ps2-gallery",category:"media",attributes:{selectedGalerie:{type:"string"},valWidgetInput:{type:"string"},hoverBGColor:{type:"string",default:""},TextColor:{type:"string",default:""}},keywords:[Object(i.__)(" Gutenberg Galerie BY Jens Wiecker"),Object(i.__)("Gutenberg POST Selector Galerie")],edit:class extends f{constructor(e){super(...arguments),this.props=e,this.updateSelectedGalerie=this.updateSelectedGalerie.bind(this),this.onOverWidgetInputChange=this.onOverWidgetInputChange.bind(this),this.onChangeBGColor=this.onChangeBGColor.bind(this),this.onChangeTextColor=this.onChangeTextColor.bind(this)}updateSelectedGalerie(e){this.props.setAttributes({selectedGalerie:e})}onOverWidgetInputChange(e){this.props.setAttributes({valWidgetInput:e})}onChangeBGColor(e){this.props.setAttributes({hoverBGColor:e})}onChangeTextColor(e){this.props.setAttributes({TextColor:e})}render(){const{overWidgetInput:e,attributes:{valWidgetInput:t=""}={}}=this.props,{inputBGColor:r,attributes:{hoverBGColor:o=""}={}}=this.props,{inputTextColor:s,attributes:{TextColor:a=""}={}}=this.props;return Object(n.createElement)("div",{className:"wp-block-hupa-post-selector-galerie"},Object(n.createElement)(l.InspectorControls,null,Object(n.createElement)("div",{id:"hupa-posts-controls"},Object(n.createElement)(p.Panel,null,Object(n.createElement)(p.PanelBody,{className:"hupa-body-sidebar",title:Object(i.__)("Settings","post-selector"),initialOpen:!0},Object(n.createElement)(p.TextControl,{className:e,label:Object(i.__)("Headline for widget:","post-selector"),value:t,onChange:this.onOverWidgetInputChange,type:"text",help:Object(i.__)("Relevant for Gutenberg widgets only.","post-selector")}))),Object(n.createElement)(p.Panel,null,Object(n.createElement)(p.PanelBody,{className:"hupa-body-sidebar",title:Object(i.__)("Colors for hover box","post-selector"),initialOpen:!1},Object(n.createElement)("div",{className:"sidebar-input-headline"},Object(i.__)("Hover text color","post-selector")),Object(n.createElement)("div",{className:s},Object(n.createElement)(l.ColorPaletteControl,{onChange:this.onChangeTextColor,value:a})),Object(n.createElement)("div",{className:"sidebar-input-headline"},Object(i.__)("Hover background color","post-selector")),Object(n.createElement)("div",{className:r},Object(n.createElement)(l.ColorPaletteControl,{onChange:this.onChangeBGColor,value:o})))))),Object(n.createElement)(p.Panel,{className:"galerie-form-panel"},Object(n.createElement)("h5",{className:"galerie-headline"},Object(i.__)("Post selector 2 gallery ","post-selector")),Object(n.createElement)(e=>{let{color:t}=e;return Object(n.createElement)("hr",{className:"hr-small-trenner"})},null),Object(n.createElement)(u,{selectedGalerie:this.props.attributes.selectedGalerie,updateSelectedGalerie:this.updateSelectedGalerie})))}},save:()=>null})}]);