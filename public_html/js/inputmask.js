!function(nt){function rt(t){var e=document.createElement("input"),a="on"+t,i=a in e;return i||(e.setAttribute(a,"return;"),i="function"==typeof e[a]),e=null,i}function o(t,e,a){var i=a.aliases[t];return i&&(i.alias&&o(i.alias,void 0,a),nt.extend(!0,a,i),nt.extend(!0,a,e),1)}function s(_){var t=void 0;function e(t,e){var a;if(null!=t&&""!=t)return 1==t.length&&0==_.greedy&&0!=_.repeat&&(_.placeholder=""),(0<_.repeat||"*"==_.repeat||"+"==_.repeat)&&(a="*"==_.repeat?0:"+"==_.repeat?1:_.repeat,t=_.groupmarker.start+t+_.groupmarker.end+_.quantifiermarker.start+a+","+_.repeat+_.quantifiermarker.end),null==nt.inputmask.masksCache[t]&&(nt.inputmask.masksCache[t]={mask:t,maskToken:function(t){var e=/(?:[?*+]|\{[0-9\+\*]+(?:,[0-9\+\*]*)?\})\??|[^.?*+^${[]()|\\]+|./g,p=!1;function a(t,e,a,i){this.matches=[],this.isGroup=t||!1,this.isOptional=e||!1,this.isQuantifier=a||!1,this.isAlternator=i||!1,this.quantifier={min:1,max:1}}function i(t,e,a){var i=_.definitions[e],n=0==t.matches.length;if(a=null!=a?a:t.matches.length,i&&!p){i.placeholder=nt.isFunction(i.placeholder)?i.placeholder.call(this,_):i.placeholder;for(var r=i.prevalidator,o=r?r.length:0,s=1;s<i.cardinality;s++){var l=s<=o?r[s-1]:[],u=l.validator,c=l.cardinality;t.matches.splice(a++,0,{fn:u?"string"==typeof u?new RegExp(u):new function(){this.test=u}:new RegExp("."),cardinality:c||1,optionality:t.isOptional,newBlockMarker:n,casing:i.casing,def:i.definitionSymbol||e,placeholder:i.placeholder,mask:e})}t.matches.splice(a++,0,{fn:i.validator?"string"==typeof i.validator?new RegExp(i.validator):new function(){this.test=i.validator}:new RegExp("."),cardinality:i.cardinality,optionality:t.isOptional,newBlockMarker:n,casing:i.casing,def:i.definitionSymbol||e,placeholder:i.placeholder,mask:e})}else t.matches.splice(a++,0,{fn:null,cardinality:0,optionality:t.isOptional,newBlockMarker:n,casing:null,def:e,placeholder:void 0,mask:e}),p=!1}for(var n,r,o,s,l=new a,u=[],c=[];h=e.exec(t);)switch((f=h[0]).charAt(0)){case _.optionalmarker.end:case _.groupmarker.end:if(n=u.pop(),0<u.length){if((r=u[u.length-1]).matches.push(n),r.isAlternator){o=u.pop();for(var d=0;d<o.matches.length;d++)o.matches[d].isGroup=!1;0<u.length?(r=u[u.length-1]).matches.push(o):l.matches.push(o)}}else l.matches.push(n);break;case _.optionalmarker.start:u.push(new a(!1,!0));break;case _.groupmarker.start:u.push(new a(!0));break;case _.quantifiermarker.start:var f,m,h,v,k=new a(!1,!1,!0),g=(f=f.replace(/[{}]/g,"")).split(","),b=isNaN(g[0])?g[0]:parseInt(g[0]),y=1==g.length?b:isNaN(g[1])?g[1]:parseInt(g[1]);"*"!=y&&"+"!=y||(b="*"==y?0:1),k.quantifier={min:b,max:y},0<u.length?((h=(m=u[u.length-1].matches).pop()).isGroup||((v=new a(!0)).matches.push(h),h=v),m.push(h),m.push(k)):((h=l.matches.pop()).isGroup||((v=new a(!0)).matches.push(h),h=v),l.matches.push(h),l.matches.push(k));break;case _.escapeChar:p=!0;break;case _.alternatormarker:(s=0<u.length?(r=u[u.length-1]).matches.pop():l.matches.pop()).isAlternator?u.push(s):((o=new a(!1,!1,!1,!0)).matches.push(s),u.push(o));break;default:if(0<u.length){if(0<(r=u[u.length-1]).matches.length&&(s=r.matches[r.matches.length-1]).isGroup&&(s.isGroup=!1,i(s,_.groupmarker.start,0),i(s,_.groupmarker.end)),i(r,f),r.isAlternator){o=u.pop();for(d=0;d<o.matches.length;d++)o.matches[d].isGroup=!1;0<u.length?(r=u[u.length-1]).matches.push(o):l.matches.push(o)}}else 0<l.matches.length&&(s=l.matches[l.matches.length-1]).isGroup&&(s.isGroup=!1,i(s,_.groupmarker.start,0),i(s,_.groupmarker.end)),i(l,f)}return 0<l.matches.length&&((s=l.matches[l.matches.length-1]).isGroup&&(s.isGroup=!1,i(s,_.groupmarker.start,0),i(s,_.groupmarker.end)),c.push(l)),c}(t),validPositions:{},_buffer:void 0,buffer:void 0,tests:{},metadata:e}),nt.extend(!0,{},nt.inputmask.masksCache[t])}function a(t){if(t=t.toString(),_.numericInput){t=t.split("").reverse();for(var e=0;e<t.length;e++)t[e]==_.optionalmarker.start?t[e]=_.optionalmarker.end:t[e]==_.optionalmarker.end?t[e]=_.optionalmarker.start:t[e]==_.groupmarker.start?t[e]=_.groupmarker.end:t[e]==_.groupmarker.end&&(t[e]=_.groupmarker.start);t=t.join("")}return t}if(nt.isFunction(_.mask)&&(_.mask=_.mask.call(this,_)),nt.isArray(_.mask)){if(1<_.mask.length){_.keepStatic=null==_.keepStatic||_.keepStatic;var i="(";return nt.each(_.mask,function(t,e){1<i.length&&(i+=")|("),null==e.mask||nt.isFunction(e.mask)?i+=a(e):i+=a(e.mask)}),e(i+=")",_.mask)}_.mask=_.mask.pop()}return _.mask&&(t=null==_.mask.mask||nt.isFunction(_.mask.mask)?e(a(_.mask),_.mask):e(a(_.mask.mask),_.mask)),t}function l(t,T,y){var c,o,s,u,_=!1,p=!1,d=!1,P=!1,f=!0;function e(t,e,a){e=e||0;var i,n,r,o,s=[],l=0;do{!0===t&&T.validPositions[l]?(r=(n=T.validPositions[l]).match,o=n.locator.slice(),s.push(!0===a?n.input:F(l,r))):(r=(i=m(l,o,l-1)).match,o=i.locator.slice(),s.push(F(l,r))),l++}while((null==u||l-1<u)&&null!=r.fn||null==r.fn&&""!=r.def||l<=e);return s.pop(),s}function E(t){var e=T;e.buffer=void 0,e.tests={},!0!==t&&(e._buffer=void 0,e.validPositions={},e.p=0)}function k(t){var e=-1,a=T.validPositions;null==t&&(t=-1);var i=e,n=e;for(var r in a){var o=parseInt(r);-1!=t&&null==a[o].match.fn||(o<=t&&(i=o),t<=o&&(n=o))}return e=-1!=i&&1<t-i||n<t?i:n}function C(t,e,a){if(y.insertMode&&null!=T.validPositions[t]&&null==a){for(var i=nt.extend(!0,{},T.validPositions),n=k(),r=t;r<=n;r++)delete T.validPositions[r];T.validPositions[t]=e;var o=!0;for(r=t;r<=n;r++){var s,l,u=i[r];if(null!=u&&(s=T.validPositions,o=v(l=!y.keepStatic&&s[r]&&(null!=s[r+1]&&1<x(r+1,s[r].locator.slice(),r).length||null!=s[r].alternation)?r+1:j(r),u.match.def)?o&&!1!==w(l,u.input,!0,!0):null==u.match.fn),!o)break}if(!o)return void(T.validPositions=nt.extend(!0,{},i))}else T.validPositions[t]=e;return 1}function h(t,e,a,i){var n=t;T.p=t,null!=T.validPositions[t]&&T.validPositions[t].input==y.radixPoint&&(e++,n++);for(var r=n;r<e;r++)null!=T.validPositions[r]&&(!0!==a&&0==y.canClearPosition(T,r,k(),i,y)||delete T.validPositions[r]);for(E(!0),r=n+1;r<=k();){for(;null!=T.validPositions[n];)n++;var o=T.validPositions[n];r<n&&(r=n+1);var s=T.validPositions[r];null!=s&&null==o?(v(n,s.match.def)&&!1!==w(n,s.input,!0)&&(delete T.validPositions[r],r++),n++):r++}var l=k();t<=l&&null!=T.validPositions[l]&&T.validPositions[l].input==y.radixPoint&&delete T.validPositions[l],E(!0)}function m(t,e,a){for(var i,n=x(t,e,a),r=k(),o=T.validPositions[r]||x(0)[0],s=null!=o.alternation?o.locator[o.alternation].split(","):[],l=0;l<n.length&&!((i=n[l]).match&&(y.greedy&&!0!==i.match.optionalQuantifier||(!1===i.match.optionality||!1===i.match.newBlockMarker)&&!0!==i.match.optionalQuantifier)&&(null==o.alternation||null!=i.locator[o.alternation]&&b(i.locator[o.alternation].toString().split(","),s)));l++);return i}function l(t){return T.validPositions[t]?T.validPositions[t].match:x(t)[0].match}function v(t,e){for(var a=!1,i=x(t),n=0;n<i.length;n++)if(i[n].match&&i[n].match.def==e){a=!0;break}return a}function x(A,t,e){var a=T.maskToken,w=t?e:0,i=t||[0],S=[],O=!1;function j(C,x,t,e){for(var M=0<x.length?x.shift():0;M<C.matches.length;M++)if(!0!==C.matches[M].isQuantifier){var a=function t(e,a,i){if(1e4<w)return alert("jquery.inputmask: There is probably an error in your mask definition or in the code. Create an issue on github with an example of the mask you are using. "+T.mask),!0;if(w==A&&null==e.matches)return S.push({match:e,locator:a.reverse()}),!0;if(null!=e.matches){if(e.isGroup&&!0!==i){if(e=t(C.matches[M+1],a))return!0}else if(e.isOptional){var n=e;(e=j(e,x,a,i))&&(P=S[S.length-1].match,0==nt.inArray(P,n.matches)&&(O=!0),w=A)}else if(e.isAlternator){var r,o=e,s=[],l=S.slice(),u=a.length,c=0<x.length?x.shift():-1;if(-1==c||"string"==typeof c){var p,d=w,f=x.slice();"string"==typeof c&&(p=c.split(","));for(var m=0;m<o.matches.length;m++){S=[],e=t(o.matches[m],[m].concat(a),i)||e,r=S.slice(),w=d,S=[];for(var h=0;h<f.length;h++)x[h]=f[h];for(var v=0;v<r.length;v++)for(var k=r[v],g=0;g<s.length;g++){var b=s[g];if(k.match.mask==b.match.mask&&("string"!=typeof c||-1!=nt.inArray(k.locator[u].toString(),p))){r.splice(v,1),b.locator[u]=b.locator[u]+","+k.locator[u],b.alternation=u;break}}s=s.concat(r)}"string"==typeof c&&(s=nt.map(s,function(t,e){if(isFinite(e)){var a=t.locator[u].toString().split(",");t.locator[u]=void 0,t.alternation=void 0;for(var i=0;i<a.length;i++)-1!=nt.inArray(a[i],p)&&(null!=t.locator[u]?(t.locator[u]+=",",t.alternation=u,t.locator[u]+=a[i]):t.locator[u]=parseInt(a[i]));if(null!=t.locator[u])return t}})),S=l.concat(s),O=!0}else e=t(o.matches[c],[c].concat(a),i);if(e)return!0}else if(e.isQuantifier&&!0!==i)for(var y=e,_=0<x.length&&!0!==i?x.shift():0;_<(isNaN(y.quantifier.max)?_+1:y.quantifier.max)&&w<=A;_++){var P,E=C.matches[nt.inArray(y,C.matches)-1];if(e=t(E,[_].concat(a),!0)){if((P=S[S.length-1].match).optionalQuantifier=_>y.quantifier.min-1,0!=nt.inArray(P,E.matches))return!0;if(_>y.quantifier.min-1){O=!0,w=A;break}return!0}}else if(e=j(e,x,a,i))return!0}else w++}(C.matches[M],[M].concat(t),e);if(a&&w==A)return a;if(A<w)break}}if(null==t){for(var n,r=A-1;null==(n=T.validPositions[r])&&-1<r;)r--;if(null!=n&&-1<r)w=r,i=n.locator.slice();else{for(r=A-1;null==(n=T.tests[r])&&-1<r;)r--;null!=n&&-1<r&&(w=r,i=n[0].locator.slice())}}for(var o=i.shift();o<a.length;o++){if(j(a[o],i,[o])&&w==A||A<w)break}return 0!=S.length&&!O||S.push({match:{fn:null,cardinality:0,optionality:!0,casing:null,def:""},locator:[]}),T.tests[A]=nt.extend(!0,[],S),T.tests[A]}function g(){return null==T._buffer&&(T._buffer=e(!1,1)),T._buffer}function M(){return null==T.buffer&&(T.buffer=e(!0,k(),!0)),T.buffer}function A(t,e,a){if(a=a||M().slice(),!0===t)E(),t=0,e=a.length;else for(var i=t;i<e;i++)delete T.validPositions[i],delete T.tests[i];for(i=t;i<e;i++)a[i]!=y.skipOptionalPartCharacter&&w(i,a[i],!0,!0)}function b(t,e){for(var a=y.greedy?e:e.slice(0,1),i=!1,n=0;n<t.length;n++)if(-1!=nt.inArray(t[n],a)){i=!0;break}return i}function w(t,e,a,i){function n(c,p,d,f){var m=!1;return nt.each(x(c),function(t,e){for(var a,i=e.match,n=p?1:0,r="",o=(M(),i.cardinality);n<o;o--)r+=(a=c-(o-1),null==T.validPositions[a]?F(a):T.validPositions[a].input);if(p&&(r+=p),!1!==(m=null!=i.fn?i.fn.test(r,T,c,d,y):(p==i.def||p==y.skipOptionalPartCharacter)&&""!=i.def&&{c:i.def,pos:c})){var s=(s=null!=m.c?m.c:p)==y.skipOptionalPartCharacter&&null===i.fn?i.def:s,l=c;if(null!=m.remove&&h(m.remove,m.remove+1,!0),m.refreshFromBuffer){var u=m.refreshFromBuffer;if(A((d=!0)===u?u:u.start,u.end),null==m.pos&&null==m.c)return m.pos=k(),!1;if((l=null!=m.pos?m.pos:c)!=c)return m=nt.extend(m,w(l,s,!0)),!1}else if(!0!==m&&null!=m.pos&&m.pos!=c&&(l=m.pos,A(c,l),l!=c))return m=nt.extend(m,w(l,s,!0)),!1;return 1!=m&&null==m.pos&&null==m.c?!1:(0<t&&E(!0),C(l,nt.extend({},e,{input:function(t,e){switch(e.casing){case"upper":t=t.toUpperCase();break;case"lower":t=t.toLowerCase()}return t}(s,i)}),f)||(m=!1),!1)}}),m}a=!0===a;for(var r=M(),o=t-1;-1<o&&!T.validPositions[o];o--);for(o++;o<t;o++)null==T.validPositions[o]&&((!S(o)||r[o]!=F(o))&&1<x(o).length||r[o]==y.radixPoint||"0"==r[o]&&nt.inArray(y.radixPoint,r)<o)&&n(o,r[o],!0);var s=t,l=!1,u=nt.extend(!0,{},T.validPositions);if(s<O()&&(l=n(s,e,a,i),!a&&!1===l)){var c=T.validPositions[s];if(!c||null!=c.match.fn||c.match.def!=e&&e!=y.skipOptionalPartCharacter){if((y.insertMode||null==T.validPositions[j(s)])&&!S(s))for(var p=s+1,d=j(s);p<=d;p++)if(!1!==(l=n(p,e,a,i))){!function(t,e){for(var a,i,n,r=T.validPositions[e].locator,o=r.length,s=t;s<e;s++){S(s)||(a=x(s),i=a[0],n=-1,nt.each(a,function(t,e){for(var a=0;a<o;a++)e.locator[a]&&b(e.locator[a].toString().split(","),r[a].toString().split(","))&&n<a&&(n=a,i=e)}),C(s,nt.extend({},i,{input:i.match.def}),!0))}}(s,p),s=p;break}}else l={caret:j(s)}}if((!1===l&&y.keepStatic&&N(r)&&(l=function(t,e,a,i){for(var n,r=nt.extend(!0,{},T.validPositions),o=k();0<=o;o--)if(T.validPositions[o]&&null!=T.validPositions[o].alternation){n=T.validPositions[o].alternation;break}if(null!=n)for(var s in T.validPositions)if(parseInt(s)>parseInt(o)&&void 0===T.validPositions[s].alternation){for(var l=T.validPositions[s].locator[n],u=T.validPositions[o].locator[n].split(","),c=0;c<u.length;c++)if(l<u[c]){for(var p,d,f=s-1;0<=f;f--)if(null!=(p=T.validPositions[f])){d=p.locator[n],p.locator[n]=u[c];break}if(l!=p.locator[n]){for(var m=M().slice(),h=s;h<k()+1;h++)delete T.validPositions[h],delete T.tests[h];E(!0),y.keepStatic=!y.keepStatic;for(h=s;h<m.length;h++)m[h]!=y.skipOptionalPartCharacter&&w(k()+1,m[h],!1,!0);p.locator[n]=d;var v=w(t,e,a,i);if(y.keepStatic=!y.keepStatic,v)return v;E(),T.validPositions=nt.extend(!0,{},r)}}break}return!1}(t,e,a,i)),!0===l&&(l={pos:s}),nt.isFunction(y.postValidation)&&0!=l&&!a)&&(E(!0),!y.postValidation(M(),y)))return E(!0),T.validPositions=nt.extend(!0,{},u),!1;return l}function S(t){var e=l(t);return null!=e.fn&&e.fn}function O(){-1==(u=tt.prop("maxLength"))&&(u=void 0);for(var t=k(),e=T.validPositions[t],a=null!=e?e.locator.slice():void 0,i=t+1;null==e||null!=e.match.fn||null==e.match.fn&&""!=e.match.def;i++)a=(e=m(i,a,i-1)).locator.slice();return null==u||i<u?i:u}function j(t){var e=O();if(e<=t)return e;for(var a=t;++a<e&&!S(a)&&(!0!==y.nojumps||y.nojumpsThreshold>a););return a}function D(t){var e=t;if(e<=0)return 0;for(;0<--e&&!S(e););return e}function G(t,e,a,i,n){var r,o;i&&nt.isFunction(y.onBeforeWrite)&&((r=y.onBeforeWrite.call(t,i,e,a,y))&&(r.refreshFromBuffer&&(A(!0===(o=r.refreshFromBuffer)?o:o.start,o.end,r.buffer),E(!0),e=M()),a=r.caret||a)),t._valueSet(e.join("")),null!=a&&K(t,a),!0===n&&(d=!0,nt(t).trigger("input"))}function F(t,e){return null!=(e=e||l(t)).placeholder?e.placeholder:null==e.fn?e.def:y.placeholder.charAt(t%y.placeholder.length)}function B(s,t,l,e){var a=null!=e?e.slice():s._valueGet().split(""),u="",c=0;E(),T.p=j(-1),t&&s._valueSet("");var i=g().slice(0,j(-1)).join(""),n=a.join("").match(new RegExp(function(t){return nt.inputmask.escapeRegex.call(this,t)}(i),"g"));n&&0<n.length&&(a.splice(0,n.length*i.length),c=j(c)),nt.each(a,function(t,e){var a=nt.Event("keypress");a.which=e.charCodeAt(0),u+=e;var i,n=k(),r=T.validPositions[n],o=m(n+1,r?r.locator.slice():void 0,n);!function(){var t=!1,e=g().slice(c,j(c)).join("").indexOf(u);if(-1!=e&&!S(c)){t=!0;for(var a=g().slice(c,c+e),i=0;i<a.length;i++)if(" "!=a[i]){t=!1;break}}return t}()||l?(i=l?t:null==o.match.fn&&o.match.optionality&&n+1<T.p?n+1:T.p,q.call(s,a,!0,!1,l,i),c=i+1,u=""):q.call(s,a,!0,!1,!0,n+1)}),t&&G(s,M(),nt(s).is(":focus")?j(k(0)):void 0,nt.Event("checkval"))}function a(t){if(!t.data("_inputmask")||t.hasClass("hasDatepicker"))return t[0]._valueGet();var e=[],a=T.validPositions;for(var i in a)a[i].match&&null!=a[i].match.fn&&e.push(a[i].input);var n=(_?e.reverse():e).join(""),r=(_?M().slice().reverse():M()).join("");return nt.isFunction(y.onUnMask)&&(n=y.onUnMask.call(t,r,n,y)||n),n}function I(t){return!_||"number"!=typeof t||y.greedy&&""==y.placeholder||(t=M().length-t),t}function K(t,e,a){var i,n,r=t.jquery&&0<t.length?t[0]:t;if("number"!=typeof e)return r.setSelectionRange?(e=r.selectionStart,a=r.selectionEnd):document.selection&&document.selection.createRange&&(a=(e=0-(i=document.selection.createRange()).duplicate().moveStart("character",-1e5))+i.text.length),{begin:I(e),end:I(a)};e=I(e),a="number"==typeof(a=I(a))?a:e,nt(r).is(":visible")&&(n=nt(r).css("font-size").replace("px","")*a,r.scrollLeft=n>r.scrollWidth?n:0,0==y.insertMode&&e==a&&a++,r.setSelectionRange?(r.selectionStart=e,r.selectionEnd=a):r.createTextRange&&((i=r.createTextRange()).collapse(!0),i.moveEnd("character",a),i.moveStart("character",e),i.select()))}function R(t){for(var e,a=M(),i=a.length,n=k(),r={},o=T.validPositions[n],s=null!=o?o.locator.slice():void 0,l=n+1;l<a.length;l++)s=(e=m(l,s,l-1)).locator.slice(),r[l]=nt.extend(!0,{},e);var u=o&&null!=o.alternation?o.locator[o.alternation].split(","):[];for(l=i-1;n<l&&(((e=r[l].match).optionality||e.optionalQuantifier||o&&null!=o.alternation&&null!=r[l].locator[o.alternation]&&-1!=nt.inArray(r[l].locator[o.alternation].toString(),u))&&a[l]==F(l,e));l--)i--;return t?{l:i,def:r[i]?r[i].match:void 0}:i}function L(t){for(var e=R(),a=t.length-1;e<a&&!S(a);a--);t.splice(e,a+1-e)}function N(t){if(nt.isFunction(y.isComplete))return y.isComplete.call(tt,t,y);if("*"!=y.repeat){var e=!1,a=R(!0),i=D(a.l);k();if(null==a.def||a.def.newBlockMarker||a.def.optionalQuantifier){e=!0;for(var n=0;n<=i;n++){var r=S(n),o=l(n);if(r&&null==T.validPositions[n]&&!0!==o.optionality&&!0!==o.optionalQuantifier||!r&&t[n]!=F(n)){e=!1;break}}}return e}}function H(e){var a,i,t,n,r,o;function s(){var t=nt(this),e=nt(this).data("_inputmask");return e?e.opts.autoUnmask?t.inputmask("unmaskedvalue"):a.call(this)!=g().join("")?a.call(this):"":a.call(this)}function l(t){var e=nt(this).data("_inputmask");e?(i.call(this,nt.isFunction(e.opts.onBeforeMask)&&e.opts.onBeforeMask.call(X,t,e.opts)||t),nt(this).triggerHandler("setvalue.inputmask")):i.call(this,t)}e._valueGet||(Object.getOwnPropertyDescriptor&&(t=Object.getOwnPropertyDescriptor(e,"value")),t&&t.configurable,document.__lookupGetter__&&e.__lookupGetter__("value")?(a=e.__lookupGetter__("value"),i=e.__lookupSetter__("value"),e.__defineGetter__("value",s),e.__defineSetter__("value",l)):(a=function(){return e.value},i=function(t){e.value=t},n=e.type,null!=nt.valHooks[n]&&1==nt.valHooks[n].inputmaskpatch||(r=nt.valHooks[n]&&nt.valHooks[n].get?nt.valHooks[n].get:function(t){return t.value},o=nt.valHooks[n]&&nt.valHooks[n].set?nt.valHooks[n].set:function(t,e){return t.value=e,t},nt.valHooks[n]={get:function(t){var e=nt(t);if(e.data("_inputmask")){if(e.data("_inputmask").opts.autoUnmask)return e.inputmask("unmaskedvalue");var a=r(t),i=e.data("_inputmask").maskset._buffer;return a!=(i=i?i.join(""):"")?a:""}return r(t)},set:function(t,e){var a,i=nt(t),n=i.data("_inputmask");return n?(a=o(t,nt.isFunction(n.opts.onBeforeMask)&&n.opts.onBeforeMask.call(X,e,n.opts)||e),i.triggerHandler("setvalue.inputmask")):a=o(t,e),a},inputmaskpatch:!0}),function(t){nt(t).bind("mouseenter.inputmask",function(t){var e=nt(this),a=this._valueGet();""!=a&&a!=M().join("")&&(this._valueSet(nt.isFunction(y.onBeforeMask)&&y.onBeforeMask.call(X,a,y)||a),e.triggerHandler("setvalue.inputmask"))});var e=nt._data(t).events.mouseover;if(e){for(var a=e[e.length-1],i=e.length-1;0<i;i--)e[i]=e[i-1];e[0]=a}}(e)),e._valueGet=function(t){return _&&!0!==t?a.call(this).split("").reverse().join(""):a.call(this)},e._valueSet=function(t){i.call(this,_?t.split("").reverse().join(""):t)})}function U(i,t,e,a){var n,r;(y.numericInput||_)&&(t==nt.inputmask.keyCode.BACKSPACE?t=nt.inputmask.keyCode.DELETE:t==nt.inputmask.keyCode.DELETE&&(t=nt.inputmask.keyCode.BACKSPACE),_&&(n=e.end,e.end=e.begin,e.begin=n)),t==nt.inputmask.keyCode.BACKSPACE&&(e.end-e.begin<1||0==y.insertMode)?e.begin=D(e.begin):t==nt.inputmask.keyCode.DELETE&&e.begin==e.end&&(e.end=S(e.end)?e.end+1:j(e.end)+1),h(e.begin,e.end,!1,a),!0!==a&&(function(){if(y.keepStatic){E(!0);for(var t=[],e=k();0<=e;e--)if(T.validPositions[e]){if(null!=T.validPositions[e].alternation)break;t.push(T.validPositions[e].input),delete T.validPositions[e]}if(0<e)for(;0<t.length;){T.p=j(k());var a=nt.Event("keypress");a.which=t.pop().charCodeAt(0),q.call(i,a,!0,!1,!1,T.p)}}}(),(r=k(e.begin))<e.begin?(-1==r&&E(),T.p=j(r)):T.p=e.begin)}function W(e){var a=this,t=nt(a),i=e.keyCode,n=K(a);i==nt.inputmask.keyCode.BACKSPACE||i==nt.inputmask.keyCode.DELETE||ot&&127==i||e.ctrlKey&&88==i&&!rt("cut")?(e.preventDefault(),88==i&&(c=M().join("")),U(a,i,n),G(a,M(),T.p,e,c!=M().join("")),a._valueGet()==g().join("")?t.trigger("cleared"):!0===N(M())&&t.trigger("complete"),y.showTooltip&&t.prop("title",T.mask)):i==nt.inputmask.keyCode.END||i==nt.inputmask.keyCode.PAGE_DOWN?setTimeout(function(){var t=j(k());y.insertMode||t!=O()||e.shiftKey||t--,K(a,e.shiftKey?n.begin:t,t)},0):i==nt.inputmask.keyCode.HOME&&!e.shiftKey||i==nt.inputmask.keyCode.PAGE_UP?K(a,0,e.shiftKey?n.begin:0):(y.undoOnEscape&&i==nt.inputmask.keyCode.ESCAPE||90==i&&e.ctrlKey)&&!0!==e.altKey?(B(a,!0,!1,c.split("")),t.click()):i!=nt.inputmask.keyCode.INSERT||e.shiftKey||e.ctrlKey?0!=y.insertMode||e.shiftKey||(i==nt.inputmask.keyCode.RIGHT?setTimeout(function(){var t=K(a);K(a,t.begin)},0):i==nt.inputmask.keyCode.LEFT&&setTimeout(function(){var t=K(a);K(a,_?t.begin+1:t.begin-1)},0)):(y.insertMode=!y.insertMode,K(a,y.insertMode||n.begin!=O()?n.begin:n.begin-1)),y.onKeyDown.call(this,e,M(),K(a).begin,y),P=-1!=nt.inArray(i,y.ignorables)}function q(t,e,a,i,n){var r,o,s,l,u,c,p,d,f,m,h,v,k,g=nt(this),b=t.which||t.charCode||t.keyCode;if(!(!0===e||t.ctrlKey&&t.altKey)&&(t.ctrlKey||t.metaKey||P))return!0;b&&(46==b&&0==t.shiftKey&&","==y.radixPoint&&(b=44),r=e?{begin:n,end:n}:K(this),o=String.fromCharCode(b),v=r.begin,k=r.end,(s=_?1<v-k||v-k==1&&y.insertMode:1<k-v||k-v==1&&y.insertMode)&&(T.undoPositions=nt.extend(!0,{},T.validPositions),U(this,nt.inputmask.keyCode.DELETE,r,!0),r.begin=T.p,y.insertMode||(y.insertMode=!y.insertMode,C(r.begin,i),y.insertMode=!y.insertMode),s=!y.multi),T.writeOutBuffer=!0,l=_&&!s?r.end:r.begin,!1!==(u=w(l,o,i))&&(!0!==u&&(l=null!=u.pos?u.pos:l,o=null!=u.c?u.c:o),E(!0),p=null!=u.caret?u.caret:(c=T.validPositions,!y.keepStatic&&(null!=c[l+1]&&1<x(l+1,c[l].locator.slice(),l).length||null!=c[l].alternation)?l+1:j(l)),T.p=p),!1!==a?(d=this,setTimeout(function(){y.onKeyValidation.call(d,u,y)},0),T.writeOutBuffer&&!1!==u?(G(this,f=M(),e?void 0:y.numericInput?D(p):p,t,!0!==e),!0!==e&&setTimeout(function(){!0===N(f)&&g.trigger("complete")},0)):s&&(T.buffer=void 0,T.validPositions=T.undoPositions)):s&&(T.buffer=void 0,T.validPositions=T.undoPositions),y.showTooltip&&g.prop("title",T.mask),e&&nt.isFunction(y.onBeforeWrite)&&((m=y.onBeforeWrite.call(this,t,M(),p,y))&&m.refreshFromBuffer&&(A(!0===(h=m.refreshFromBuffer)?h:h.start,h.end,m.buffer),E(!0),m.caret&&(T.p=m.caret))),t.preventDefault())}function Q(t){var e,a,i=this,n=nt(i),r=i._valueGet(!0),o=K(i);if("propertychange"==t.type&&i._valueGet().length<=O())return!0;"paste"==t.type&&(e=r.substr(0,o.begin),a=r.substr(o.end,r.length),e==g().slice(0,o.begin).join("")&&(e=""),a==g().slice(o.end).join("")&&(a=""),window.clipboardData&&window.clipboardData.getData?r=e+window.clipboardData.getData("Text")+a:t.originalEvent&&t.originalEvent.clipboardData&&t.originalEvent.clipboardData.getData&&(r=e+t.originalEvent.clipboardData.getData("text/plain")+a));var s=r;if(nt.isFunction(y.onBeforePaste)){if(!1===(s=y.onBeforePaste.call(i,r,y)))return t.preventDefault(),!1;s=s||r}return B(i,!0,!1,_?s.split("").reverse():s.split("")),n.click(),!0===N(M())&&n.trigger("complete"),!1}function V(t){B(this,!0,!1),!0===N(M())&&nt(this).trigger("complete"),t.preventDefault()}function $(t){c=M().join(""),""!=s&&0==t.originalEvent.data.indexOf(s)||(o=K(this))}function z(t){var e=this,a=o||K(e);0==t.originalEvent.data.indexOf(s)&&(E(),a={begin:0,end:0});var i=t.originalEvent.data;K(e,a.begin,a.end);for(var n=0;n<i.length;n++){var r=nt.Event("keypress");r.which=i.charCodeAt(n),P=p=!1,q.call(e,r)}setTimeout(function(){var t=T.p;G(e,M(),y.numericInput?D(t):t)},0),s=t.originalEvent.data}function J(t){}if(null!=t)switch(t.action){case"isComplete":return tt=nt(t.el),T=tt.data("_inputmask").maskset,y=tt.data("_inputmask").opts,N(t.buffer);case"unmaskedvalue":return tt=t.$input,T=tt.data("_inputmask").maskset,y=tt.data("_inputmask").opts,_=t.$input.data("_inputmask").isRTL,a(t.$input);case"mask":c=M().join(""),function(t){if((tt=nt(t)).is(":input")&&(s=tt.attr("type"),(u="text"==s||"tel"==s)||((l=document.createElement("input")).setAttribute("type",s),u="text"===l.type,l=null),u)){var e;tt.data("_inputmask",{maskset:T,opts:y,isRTL:!1}),y.showTooltip&&tt.prop("title",T.mask),"rtl"!=t.dir&&!y.rightAlign||tt.css("text-align","right"),"rtl"!=t.dir&&!y.numericInput||(t.dir="ltr",tt.removeAttr("dir"),(e=tt.data("_inputmask")).isRTL=!0,tt.data("_inputmask",e),_=!0),tt.unbind(".inputmask"),tt.closest("form").bind("submit",function(t){c!=M().join("")&&tt.change(),tt[0]._valueGet&&tt[0]._valueGet()==g().join("")&&tt[0]._valueSet(""),y.removeMaskOnSubmit&&tt.inputmask("remove")}).bind("reset",function(){setTimeout(function(){tt.triggerHandler("setvalue.inputmask")},0)}),tt.bind("mouseenter.inputmask",function(){!nt(this).is(":focus")&&y.showMaskOnHover&&this._valueGet()!=M().join("")&&G(this,M())}).bind("blur.inputmask",function(t){var e,a,i=nt(this);i.data("_inputmask")&&(e=this._valueGet(),a=M().slice(),f=!0,c!=a.join("")&&setTimeout(function(){i.change(),c=a.join("")},0),""!=e&&(y.clearMaskOnLostFocus&&(e==g().join("")?a=[]:L(a)),!1===N(a)&&(i.trigger("incomplete"),y.clearIncomplete&&(E(),a=y.clearMaskOnLostFocus?[]:g().slice())),G(this,a,void 0,t)))}).bind("focus.inputmask",function(t){nt(this);var e=this._valueGet();y.showMaskOnFocus&&(!y.showMaskOnHover||y.showMaskOnHover&&""==e)&&this._valueGet()!=M().join("")&&G(this,M(),j(k())),c=M().join("")}).bind("mouseleave.inputmask",function(){var t,e,a=nt(this);y.clearMaskOnLostFocus&&(t=M().slice(),e=this._valueGet(),a.is(":focus")||e==a.attr("placeholder")||""==e||(e==g().join("")?t=[]:L(t),G(this,t)))}).bind("click.inputmask",function(){var t,e,a;!nt(this).is(":focus")||(t=K(this)).begin==t.end&&(y.radixFocus&&""!=y.radixPoint&&-1!=nt.inArray(y.radixPoint,M())&&(f||M().join("")==g().join(""))?(K(this,nt.inArray(y.radixPoint,M())),f=!1):K(this,(e=_?I(t.begin):t.begin)<(a=j(k(e)))?S(e)?e:j(e):a))}).bind("dblclick.inputmask",function(){var t=this;setTimeout(function(){K(t,0,j(k()))},0)}).bind(lt+".inputmask dragdrop.inputmask drop.inputmask",Q).bind("setvalue.inputmask",function(){B(this,!0,!1),c=M().join(""),(y.clearMaskOnLostFocus||y.clearIncomplete)&&this._valueGet()==g().join("")&&this._valueSet("")}).bind("cut.inputmask",function(t){d=!0;var e=this,a=nt(e),i=K(e);U(e,nt.inputmask.keyCode.DELETE,i),G(e,M(),T.p,t,c!=M().join("")),e._valueGet()==g().join("")&&a.trigger("cleared"),y.showTooltip&&a.prop("title",T.mask)}).bind("complete.inputmask",y.oncomplete).bind("incomplete.inputmask",y.onincomplete).bind("cleared.inputmask",y.oncleared),tt.bind("keydown.inputmask",W).bind("keypress.inputmask",q),st||tt.bind("compositionstart.inputmask",$).bind("compositionupdate.inputmask",z).bind("compositionend.inputmask",J),"paste"==lt&&tt.bind("input.inputmask",V),H(t);var a=nt.isFunction(y.onBeforeMask)&&y.onBeforeMask.call(t,t._valueGet(),y)||t._valueGet();B(t,!0,!1,a.split(""));var i,n=M().slice();c=n.join("");try{i=document.activeElement}catch(t){}!1===N(n)&&y.clearIncomplete&&E(),y.clearMaskOnLostFocus&&(n.join("")==g().join("")?n=[]:L(n)),G(t,n),i===t&&K(t,j(k())),r=t,o=nt._data(r).events,nt.each(o,function(t,e){nt.each(e,function(t,e){var a;"inputmask"==e.namespace&&"setvalue"!=e.type&&(a=e.handler,e.handler=function(t){if(!this.disabled&&(!this.readOnly||"keydown"==t.type&&t.ctrlKey&&67==t.keyCode)){switch(t.type){case"input":if(!0===d)return d=!1,t.preventDefault();break;case"keydown":p=!1;break;case"keypress":if(!0===p)return t.preventDefault();p=!0;break;case"compositionstart":break;case"compositionupdate":d=!0}return a.apply(this,arguments)}t.preventDefault()})})})}var r,o,s,l,u}(t.el);break;case"format":(tt=nt({})).data("_inputmask",{maskset:T,opts:y,isRTL:y.numericInput}),y.numericInput&&(_=!0);var i=(nt.isFunction(y.onBeforeMask)&&y.onBeforeMask.call(tt,t.value,y)||t.value).split("");return B(tt,!1,!1,_?i.reverse():i),nt.isFunction(y.onBeforeWrite)&&y.onBeforeWrite.call(this,void 0,M(),0,y),t.metadata?{value:_?M().slice().reverse().join(""):M().join(""),metadata:tt.inputmask("getmetadata")}:_?M().slice().reverse().join(""):M().join("");case"isValid":(tt=nt({})).data("_inputmask",{maskset:T,opts:y,isRTL:y.numericInput}),y.numericInput&&(_=!0);i=t.value.split("");B(tt,!1,!0,_?i.reverse():i);for(var n=M(),r=R(),Z=n.length-1;r<Z&&!S(Z);Z--);return n.splice(r,Z+1-r),N(n)&&t.value==n.join("");case"getemptymask":return tt=nt(t.el),T=tt.data("_inputmask").maskset,y=tt.data("_inputmask").opts,g();case"remove":var Y,X=t.el,tt=nt(X);T=tt.data("_inputmask").maskset,y=tt.data("_inputmask").opts,X._valueSet(a(tt)),tt.unbind(".inputmask"),tt.removeData("_inputmask"),Object.getOwnPropertyDescriptor&&(Y=Object.getOwnPropertyDescriptor(X,"value")),Y&&Y.get?X._valueGet&&Object.defineProperty(X,"value",{get:X._valueGet,set:X._valueSet}):document.__lookupGetter__&&X.__lookupGetter__("value")&&X._valueGet&&(X.__defineGetter__("value",X._valueGet),X.__defineSetter__("value",X._valueSet));try{delete X._valueGet,delete X._valueSet}catch(t){X._valueGet=void 0,X._valueSet=void 0}break;case"getmetadata":if(tt=nt(t.el),T=tt.data("_inputmask").maskset,y=tt.data("_inputmask").opts,nt.isArray(T.metadata)){for(var et,at=k(),it=at;0<=it;it--)if(T.validPositions[it]&&null!=T.validPositions[it].alternation){et=T.validPositions[it].alternation;break}return null!=et?T.metadata[T.validPositions[at].locator[et]]:T.metadata[0]}return T.metadata}}var t,ot,st,lt;void 0===nt.fn.inputmask&&(t=navigator.userAgent,ot=null!==t.match(new RegExp("iphone","i")),t.match(new RegExp("android.*safari.*","i")),t.match(new RegExp("android.*chrome.*","i")),st=null!==t.match(new RegExp("android.*firefox.*","i")),/Kindle/i.test(t)||/Silk/i.test(t)||/KFTT/i.test(t)||/KFOT/i.test(t)||/KFJWA/i.test(t)||/KFJWI/i.test(t)||/KFSOWI/i.test(t)||/KFTHWA/i.test(t)||/KFTHWI/i.test(t)||/KFAPWA/i.test(t)||/KFAPWI/i.test(t),lt=rt("paste")?"paste":rt("input")?"input":"propertychange",nt.inputmask={defaults:{placeholder:"_",optionalmarker:{start:"[",end:"]"},quantifiermarker:{start:"{",end:"}"},groupmarker:{start:"(",end:")"},alternatormarker:"|",escapeChar:"\\",mask:null,oncomplete:nt.noop,onincomplete:nt.noop,oncleared:nt.noop,repeat:0,greedy:!0,autoUnmask:!1,removeMaskOnSubmit:!1,clearMaskOnLostFocus:!0,insertMode:!0,clearIncomplete:!1,aliases:{},alias:null,onKeyDown:nt.noop,onBeforeMask:void 0,onBeforePaste:void 0,onBeforeWrite:void 0,onUnMask:void 0,showMaskOnFocus:!0,showMaskOnHover:!0,onKeyValidation:nt.noop,skipOptionalPartCharacter:" ",showTooltip:!1,numericInput:!1,rightAlign:!1,undoOnEscape:!0,radixPoint:"",radixFocus:!1,nojumps:!1,nojumpsThreshold:0,keepStatic:void 0,definitions:{9:{validator:"[0-9]",cardinality:1,definitionSymbol:"*"},a:{validator:"[A-Za-zА-яЁёÀ-ÿµ]",cardinality:1,definitionSymbol:"*"},"*":{validator:"[0-9A-Za-zА-яЁёÀ-ÿµ]",cardinality:1}},ignorables:[8,9,13,19,27,33,34,35,36,37,38,39,40,45,46,93,112,113,114,115,116,117,118,119,120,121,122,123],isComplete:void 0,canClearPosition:nt.noop,postValidation:void 0},keyCode:{ALT:18,BACKSPACE:8,CAPS_LOCK:20,COMMA:188,COMMAND:91,COMMAND_LEFT:91,COMMAND_RIGHT:93,CONTROL:17,DELETE:46,DOWN:40,END:35,ENTER:13,ESCAPE:27,HOME:36,INSERT:45,LEFT:37,MENU:93,NUMPAD_ADD:107,NUMPAD_DECIMAL:110,NUMPAD_DIVIDE:111,NUMPAD_ENTER:108,NUMPAD_MULTIPLY:106,NUMPAD_SUBTRACT:109,PAGE_DOWN:34,PAGE_UP:33,PERIOD:190,RIGHT:39,SHIFT:16,SPACE:32,TAB:9,UP:38,WINDOWS:91},masksCache:{},escapeRegex:function(t){return t.replace(new RegExp("(\\"+["/",".","*","+","?","|","(",")","[","]","{","}","\\","$","^"].join("|\\")+")","gim"),"\\$1")},format:function(t,e,a){var i=nt.extend(!0,{},nt.inputmask.defaults,e);return o(i.alias,e,i),l({action:"format",value:t,metadata:a},s(i),i)},isValid:function(t,e){var a=nt.extend(!0,{},nt.inputmask.defaults,e);return o(a.alias,e,a),l({action:"isValid",value:t},s(a),a)}},nt.fn.inputmask=function(t,i){function n(t,e,a){var i=nt(t);for(var n in i.data("inputmask-alias")&&o(i.data("inputmask-alias"),{},e),e){var r=i.data("inputmask-"+n.toLowerCase());null!=r&&("mask"==n&&0==r.indexOf("[")?(e[n]=r.replace(/[\s[\]]/g,"").split("','"),e[n][0]=e[n][0].replace("'",""),e[n][e[n].length-1]=e[n][e[n].length-1].replace("'","")):e[n]="boolean"==typeof r?r:r.toString(),a&&(a[n]=e[n]))}return e}var e,r=nt.extend(!0,{},nt.inputmask.defaults,i);if("string"==typeof t)switch(t){case"mask":return o(r.alias,i,r),null==(e=s(r))?this:this.each(function(){l({action:"mask",el:this},nt.extend(!0,{},e),n(this,r))});case"unmaskedvalue":var a=nt(this);return a.data("_inputmask")?l({action:"unmaskedvalue",$input:a}):a.val();case"remove":return this.each(function(){nt(this).data("_inputmask")&&l({action:"remove",el:this})});case"getemptymask":return this.data("_inputmask")?l({action:"getemptymask",el:this}):"";case"hasMaskedValue":return!!this.data("_inputmask")&&!this.data("_inputmask").opts.autoUnmask;case"isComplete":return!this.data("_inputmask")||l({action:"isComplete",buffer:this[0]._valueGet().split(""),el:this});case"getmetadata":return this.data("_inputmask")?l({action:"getmetadata",el:this}):void 0;default:return o(r.alias,i,r),o(t,i,r)||(r.mask=t),null==(e=s(r))?this:this.each(function(){l({action:"mask",el:this},nt.extend(!0,{},e),n(this,r))})}else{if("object"==typeof t)return o((r=nt.extend(!0,{},nt.inputmask.defaults,t)).alias,t,r),null==(e=s(r))?this:this.each(function(){l({action:"mask",el:this},nt.extend(!0,{},e),n(this,r))});if(null==t)return this.each(function(){var t,e=nt(this).attr("data-inputmask");if(e&&""!=e)try{e=e.replace(new RegExp("'","g"),'"');var a=nt.parseJSON("{"+e+"}");nt.extend(!0,a,i),o((r=n(this,r=nt.extend(!0,{},nt.inputmask.defaults,a))).alias,a,r),r.alias=void 0,nt(this).inputmask("mask",r)}catch(t){}(nt(this).attr("data-inputmask-mask")||nt(this).attr("data-inputmask-alias"))&&(t={},o((r=n(this,r=nt.extend(!0,{},nt.inputmask.defaults,{}),t)).alias,t,r),r.alias=void 0,nt(this).inputmask("mask",r))})}}),nt.fn.inputmask}(jQuery);