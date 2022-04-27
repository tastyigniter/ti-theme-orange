/*! jQuery v3.6.0 | (c) OpenJS Foundation and other contributors | jquery.org/license */
!function (e, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function (e) {
        if (!e.document) throw new Error("jQuery requires a window with a document");
        return t(e)
    } : t(e)
}("undefined" != typeof window ? window : this, function (C, e) {
    "use strict";
    var t = [], r = Object.getPrototypeOf, s = t.slice, g = t.flat ? function (e) {
            return t.flat.call(e)
        } : function (e) {
            return t.concat.apply([], e)
        }, u = t.push, i = t.indexOf, n = {}, o = n.toString, v = n.hasOwnProperty, a = v.toString, l = a.call(Object),
        y = {}, m = function (e) {
            return "function" == typeof e && "number" != typeof e.nodeType && "function" != typeof e.item
        }, x = function (e) {
            return null != e && e === e.window
        }, E = C.document, c = {type: !0, src: !0, nonce: !0, noModule: !0};

    function b(e, t, n) {
        var r, i, o = (n = n || E).createElement("script");
        if (o.text = e, t) for (r in c) (i = t[r] || t.getAttribute && t.getAttribute(r)) && o.setAttribute(r, i);
        n.head.appendChild(o).parentNode.removeChild(o)
    }

    function w(e) {
        return null == e ? e+"" : "object" == typeof e || "function" == typeof e ? n[o.call(e)] || "object" : typeof e
    }

    var f = "3.6.0", S = function (e, t) {
        return new S.fn.init(e, t)
    };

    function p(e) {
        var t = !!e && "length" in e && e.length, n = w(e);
        return !m(e) && !x(e) && ("array" === n || 0 === t || "number" == typeof t && 0 < t && t-1 in e)
    }

    S.fn = S.prototype = {
        jquery: f, constructor: S, length: 0, toArray: function () {
            return s.call(this)
        }, get: function (e) {
            return null == e ? s.call(this) : e < 0 ? this[e+this.length] : this[e]
        }, pushStack: function (e) {
            var t = S.merge(this.constructor(), e);
            return t.prevObject = this, t
        }, each: function (e) {
            return S.each(this, e)
        }, map: function (n) {
            return this.pushStack(S.map(this, function (e, t) {
                return n.call(e, t, e)
            }))
        }, slice: function () {
            return this.pushStack(s.apply(this, arguments))
        }, first: function () {
            return this.eq(0)
        }, last: function () {
            return this.eq(-1)
        }, even: function () {
            return this.pushStack(S.grep(this, function (e, t) {
                return (t+1) % 2
            }))
        }, odd: function () {
            return this.pushStack(S.grep(this, function (e, t) {
                return t % 2
            }))
        }, eq: function (e) {
            var t = this.length, n = +e+(e < 0 ? t : 0);
            return this.pushStack(0 <= n && n < t ? [this[n]] : [])
        }, end: function () {
            return this.prevObject || this.constructor()
        }, push: u, sort: t.sort, splice: t.splice
    }, S.extend = S.fn.extend = function () {
        var e, t, n, r, i, o, a = arguments[0] || {}, s = 1, u = arguments.length, l = !1;
        for ("boolean" == typeof a && (l = a, a = arguments[s] || {}, s++), "object" == typeof a || m(a) || (a = {}), s === u && (a = this, s--); s < u; s++) if (null != (e = arguments[s])) for (t in e) r = e[t], "__proto__" !== t && a !== r && (l && r && (S.isPlainObject(r) || (i = Array.isArray(r))) ? (n = a[t], o = i && !Array.isArray(n) ? [] : i || S.isPlainObject(n) ? n : {}, i = !1, a[t] = S.extend(l, o, r)) : void 0 !== r && (a[t] = r));
        return a
    }, S.extend({
        expando: "jQuery"+(f+Math.random()).replace(/\D/g, ""), isReady: !0, error: function (e) {
            throw new Error(e)
        }, noop: function () {
        }, isPlainObject: function (e) {
            var t, n;
            return !(!e || "[object Object]" !== o.call(e)) && (!(t = r(e)) || "function" == typeof (n = v.call(t, "constructor") && t.constructor) && a.call(n) === l)
        }, isEmptyObject: function (e) {
            var t;
            for (t in e) return !1;
            return !0
        }, globalEval: function (e, t, n) {
            b(e, {nonce: t && t.nonce}, n)
        }, each: function (e, t) {
            var n, r = 0;
            if (p(e)) {
                for (n = e.length; r < n; r++) if (!1 === t.call(e[r], r, e[r])) break
            } else for (r in e) if (!1 === t.call(e[r], r, e[r])) break;
            return e
        }, makeArray: function (e, t) {
            var n = t || [];
            return null != e && (p(Object(e)) ? S.merge(n, "string" == typeof e ? [e] : e) : u.call(n, e)), n
        }, inArray: function (e, t, n) {
            return null == t ? -1 : i.call(t, e, n)
        }, merge: function (e, t) {
            for (var n = +t.length, r = 0, i = e.length; r < n; r++) e[i++] = t[r];
            return e.length = i, e
        }, grep: function (e, t, n) {
            for (var r = [], i = 0, o = e.length, a = !n; i < o; i++) !t(e[i], i) !== a && r.push(e[i]);
            return r
        }, map: function (e, t, n) {
            var r, i, o = 0, a = [];
            if (p(e)) for (r = e.length; o < r; o++) null != (i = t(e[o], o, n)) && a.push(i); else for (o in e) null != (i = t(e[o], o, n)) && a.push(i);
            return g(a)
        }, guid: 1, support: y
    }), "function" == typeof Symbol && (S.fn[Symbol.iterator] = t[Symbol.iterator]), S.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function (e, t) {
        n["[object "+t+"]"] = t.toLowerCase()
    });
    var d = function (n) {
        var e, d, b, o, i, h, f, g, w, u, l, T, C, a, E, v, s, c, y, S = "sizzle"+1 * new Date, p = n.document, k = 0,
            r = 0, m = ue(), x = ue(), A = ue(), N = ue(), j = function (e, t) {
                return e === t && (l = !0), 0
            }, D = {}.hasOwnProperty, t = [], q = t.pop, L = t.push, H = t.push, O = t.slice, P = function (e, t) {
                for (var n = 0, r = e.length; n < r; n++) if (e[n] === t) return n;
                return -1
            },
            R = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
            M = "[\\x20\\t\\r\\n\\f]", I = "(?:\\\\[\\da-fA-F]{1,6}"+M+"?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
            W = "\\["+M+"*("+I+")(?:"+M+"*([*^$|!~]?=)"+M+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+I+"))|)"+M+"*\\]",
            F = ":("+I+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+W+")*)|.*)\\)|)",
            B = new RegExp(M+"+", "g"), $ = new RegExp("^"+M+"+|((?:^|[^\\\\])(?:\\\\.)*)"+M+"+$", "g"),
            _ = new RegExp("^"+M+"*,"+M+"*"), z = new RegExp("^"+M+"*([>+~]|"+M+")"+M+"*"), U = new RegExp(M+"|>"),
            X = new RegExp(F), V = new RegExp("^"+I+"$"), G = {
                ID: new RegExp("^#("+I+")"),
                CLASS: new RegExp("^\\.("+I+")"),
                TAG: new RegExp("^("+I+"|[*])"),
                ATTR: new RegExp("^"+W),
                PSEUDO: new RegExp("^"+F),
                CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+M+"*(even|odd|(([+-]|)(\\d*)n|)"+M+"*(?:([+-]|)"+M+"*(\\d+)|))"+M+"*\\)|)", "i"),
                bool: new RegExp("^(?:"+R+")$", "i"),
                needsContext: new RegExp("^"+M+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+M+"*((?:-\\d)?\\d*)"+M+"*\\)|)(?=[^-]|$)", "i")
            }, Y = /HTML$/i, Q = /^(?:input|select|textarea|button)$/i, J = /^h\d$/i, K = /^[^{]+\{\s*\[native \w/,
            Z = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/, ee = /[+~]/,
            te = new RegExp("\\\\[\\da-fA-F]{1,6}"+M+"?|\\\\([^\\r\\n\\f])", "g"), ne = function (e, t) {
                var n = "0x"+e.slice(1)-65536;
                return t || (n < 0 ? String.fromCharCode(n+65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320))
            }, re = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g, ie = function (e, t) {
                return t ? "\0" === e ? "\ufffd" : e.slice(0, -1)+"\\"+e.charCodeAt(e.length-1).toString(16)+" " : "\\"+e
            }, oe = function () {
                T()
            }, ae = be(function (e) {
                return !0 === e.disabled && "fieldset" === e.nodeName.toLowerCase()
            }, {dir: "parentNode", next: "legend"});
        try {
            H.apply(t = O.call(p.childNodes), p.childNodes), t[p.childNodes.length].nodeType
        } catch (e) {
            H = {
                apply: t.length ? function (e, t) {
                    L.apply(e, O.call(t))
                } : function (e, t) {
                    var n = e.length, r = 0;
                    while (e[n++] = t[r++]) ;
                    e.length = n-1
                }
            }
        }

        function se(t, e, n, r) {
            var i, o, a, s, u, l, c, f = e && e.ownerDocument, p = e ? e.nodeType : 9;
            if (n = n || [], "string" != typeof t || !t || 1 !== p && 9 !== p && 11 !== p) return n;
            if (!r && (T(e), e = e || C, E)) {
                if (11 !== p && (u = Z.exec(t))) if (i = u[1]) {
                    if (9 === p) {
                        if (!(a = e.getElementById(i))) return n;
                        if (a.id === i) return n.push(a), n
                    } else if (f && (a = f.getElementById(i)) && y(e, a) && a.id === i) return n.push(a), n
                } else {
                    if (u[2]) return H.apply(n, e.getElementsByTagName(t)), n;
                    if ((i = u[3]) && d.getElementsByClassName && e.getElementsByClassName) return H.apply(n, e.getElementsByClassName(i)), n
                }
                if (d.qsa && !N[t+" "] && (!v || !v.test(t)) && (1 !== p || "object" !== e.nodeName.toLowerCase())) {
                    if (c = t, f = e, 1 === p && (U.test(t) || z.test(t))) {
                        (f = ee.test(t) && ye(e.parentNode) || e) === e && d.scope || ((s = e.getAttribute("id")) ? s = s.replace(re, ie) : e.setAttribute("id", s = S)), o = (l = h(t)).length;
                        while (o--) l[o] = (s ? "#"+s : ":scope")+" "+xe(l[o]);
                        c = l.join(",")
                    }
                    try {
                        return H.apply(n, f.querySelectorAll(c)), n
                    } catch (e) {
                        N(t, !0)
                    } finally {
                        s === S && e.removeAttribute("id")
                    }
                }
            }
            return g(t.replace($, "$1"), e, n, r)
        }

        function ue() {
            var r = [];
            return function e(t, n) {
                return r.push(t+" ") > b.cacheLength && delete e[r.shift()], e[t+" "] = n
            }
        }

        function le(e) {
            return e[S] = !0, e
        }

        function ce(e) {
            var t = C.createElement("fieldset");
            try {
                return !!e(t)
            } catch (e) {
                return !1
            } finally {
                t.parentNode && t.parentNode.removeChild(t), t = null
            }
        }

        function fe(e, t) {
            var n = e.split("|"), r = n.length;
            while (r--) b.attrHandle[n[r]] = t
        }

        function pe(e, t) {
            var n = t && e, r = n && 1 === e.nodeType && 1 === t.nodeType && e.sourceIndex-t.sourceIndex;
            if (r) return r;
            if (n) while (n = n.nextSibling) if (n === t) return -1;
            return e ? 1 : -1
        }

        function de(t) {
            return function (e) {
                return "input" === e.nodeName.toLowerCase() && e.type === t
            }
        }

        function he(n) {
            return function (e) {
                var t = e.nodeName.toLowerCase();
                return ("input" === t || "button" === t) && e.type === n
            }
        }

        function ge(t) {
            return function (e) {
                return "form" in e ? e.parentNode && !1 === e.disabled ? "label" in e ? "label" in e.parentNode ? e.parentNode.disabled === t : e.disabled === t : e.isDisabled === t || e.isDisabled !== !t && ae(e) === t : e.disabled === t : "label" in e && e.disabled === t
            }
        }

        function ve(a) {
            return le(function (o) {
                return o = +o, le(function (e, t) {
                    var n, r = a([], e.length, o), i = r.length;
                    while (i--) e[n = r[i]] && (e[n] = !(t[n] = e[n]))
                })
            })
        }

        function ye(e) {
            return e && "undefined" != typeof e.getElementsByTagName && e
        }

        for (e in d = se.support = {}, i = se.isXML = function (e) {
            var t = e && e.namespaceURI, n = e && (e.ownerDocument || e).documentElement;
            return !Y.test(t || n && n.nodeName || "HTML")
        }, T = se.setDocument = function (e) {
            var t, n, r = e ? e.ownerDocument || e : p;
            return r != C && 9 === r.nodeType && r.documentElement && (a = (C = r).documentElement, E = !i(C), p != C && (n = C.defaultView) && n.top !== n && (n.addEventListener ? n.addEventListener("unload", oe, !1) : n.attachEvent && n.attachEvent("onunload", oe)), d.scope = ce(function (e) {
                return a.appendChild(e).appendChild(C.createElement("div")), "undefined" != typeof e.querySelectorAll && !e.querySelectorAll(":scope fieldset div").length
            }), d.attributes = ce(function (e) {
                return e.className = "i", !e.getAttribute("className")
            }), d.getElementsByTagName = ce(function (e) {
                return e.appendChild(C.createComment("")), !e.getElementsByTagName("*").length
            }), d.getElementsByClassName = K.test(C.getElementsByClassName), d.getById = ce(function (e) {
                return a.appendChild(e).id = S, !C.getElementsByName || !C.getElementsByName(S).length
            }), d.getById ? (b.filter.ID = function (e) {
                var t = e.replace(te, ne);
                return function (e) {
                    return e.getAttribute("id") === t
                }
            }, b.find.ID = function (e, t) {
                if ("undefined" != typeof t.getElementById && E) {
                    var n = t.getElementById(e);
                    return n ? [n] : []
                }
            }) : (b.filter.ID = function (e) {
                var n = e.replace(te, ne);
                return function (e) {
                    var t = "undefined" != typeof e.getAttributeNode && e.getAttributeNode("id");
                    return t && t.value === n
                }
            }, b.find.ID = function (e, t) {
                if ("undefined" != typeof t.getElementById && E) {
                    var n, r, i, o = t.getElementById(e);
                    if (o) {
                        if ((n = o.getAttributeNode("id")) && n.value === e) return [o];
                        i = t.getElementsByName(e), r = 0;
                        while (o = i[r++]) if ((n = o.getAttributeNode("id")) && n.value === e) return [o]
                    }
                    return []
                }
            }), b.find.TAG = d.getElementsByTagName ? function (e, t) {
                return "undefined" != typeof t.getElementsByTagName ? t.getElementsByTagName(e) : d.qsa ? t.querySelectorAll(e) : void 0
            } : function (e, t) {
                var n, r = [], i = 0, o = t.getElementsByTagName(e);
                if ("*" === e) {
                    while (n = o[i++]) 1 === n.nodeType && r.push(n);
                    return r
                }
                return o
            }, b.find.CLASS = d.getElementsByClassName && function (e, t) {
                if ("undefined" != typeof t.getElementsByClassName && E) return t.getElementsByClassName(e)
            }, s = [], v = [], (d.qsa = K.test(C.querySelectorAll)) && (ce(function (e) {
                var t;
                a.appendChild(e).innerHTML = "<a id='"+S+"'></a><select id='"+S+"-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && v.push("[*^$]="+M+"*(?:''|\"\")"), e.querySelectorAll("[selected]").length || v.push("\\["+M+"*(?:value|"+R+")"), e.querySelectorAll("[id~="+S+"-]").length || v.push("~="), (t = C.createElement("input")).setAttribute("name", ""), e.appendChild(t), e.querySelectorAll("[name='']").length || v.push("\\["+M+"*name"+M+"*="+M+"*(?:''|\"\")"), e.querySelectorAll(":checked").length || v.push(":checked"), e.querySelectorAll("a#"+S+"+*").length || v.push(".#.+[+~]"), e.querySelectorAll("\\\f"), v.push("[\\r\\n\\f]")
            }), ce(function (e) {
                e.innerHTML = "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                var t = C.createElement("input");
                t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && v.push("name"+M+"*[*^$|!~]?="), 2 !== e.querySelectorAll(":enabled").length && v.push(":enabled", ":disabled"), a.appendChild(e).disabled = !0, 2 !== e.querySelectorAll(":disabled").length && v.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), v.push(",.*:")
            })), (d.matchesSelector = K.test(c = a.matches || a.webkitMatchesSelector || a.mozMatchesSelector || a.oMatchesSelector || a.msMatchesSelector)) && ce(function (e) {
                d.disconnectedMatch = c.call(e, "*"), c.call(e, "[s!='']:x"), s.push("!=", F)
            }), v = v.length && new RegExp(v.join("|")), s = s.length && new RegExp(s.join("|")), t = K.test(a.compareDocumentPosition), y = t || K.test(a.contains) ? function (e, t) {
                var n = 9 === e.nodeType ? e.documentElement : e, r = t && t.parentNode;
                return e === r || !(!r || 1 !== r.nodeType || !(n.contains ? n.contains(r) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(r)))
            } : function (e, t) {
                if (t) while (t = t.parentNode) if (t === e) return !0;
                return !1
            }, j = t ? function (e, t) {
                if (e === t) return l = !0, 0;
                var n = !e.compareDocumentPosition- !t.compareDocumentPosition;
                return n || (1 & (n = (e.ownerDocument || e) == (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !d.sortDetached && t.compareDocumentPosition(e) === n ? e == C || e.ownerDocument == p && y(p, e) ? -1 : t == C || t.ownerDocument == p && y(p, t) ? 1 : u ? P(u, e)-P(u, t) : 0 : 4 & n ? -1 : 1)
            } : function (e, t) {
                if (e === t) return l = !0, 0;
                var n, r = 0, i = e.parentNode, o = t.parentNode, a = [e], s = [t];
                if (!i || !o) return e == C ? -1 : t == C ? 1 : i ? -1 : o ? 1 : u ? P(u, e)-P(u, t) : 0;
                if (i === o) return pe(e, t);
                n = e;
                while (n = n.parentNode) a.unshift(n);
                n = t;
                while (n = n.parentNode) s.unshift(n);
                while (a[r] === s[r]) r++;
                return r ? pe(a[r], s[r]) : a[r] == p ? -1 : s[r] == p ? 1 : 0
            }), C
        }, se.matches = function (e, t) {
            return se(e, null, null, t)
        }, se.matchesSelector = function (e, t) {
            if (T(e), d.matchesSelector && E && !N[t+" "] && (!s || !s.test(t)) && (!v || !v.test(t))) try {
                var n = c.call(e, t);
                if (n || d.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n
            } catch (e) {
                N(t, !0)
            }
            return 0 < se(t, C, null, [e]).length
        }, se.contains = function (e, t) {
            return (e.ownerDocument || e) != C && T(e), y(e, t)
        }, se.attr = function (e, t) {
            (e.ownerDocument || e) != C && T(e);
            var n = b.attrHandle[t.toLowerCase()],
                r = n && D.call(b.attrHandle, t.toLowerCase()) ? n(e, t, !E) : void 0;
            return void 0 !== r ? r : d.attributes || !E ? e.getAttribute(t) : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
        }, se.escape = function (e) {
            return (e+"").replace(re, ie)
        }, se.error = function (e) {
            throw new Error("Syntax error, unrecognized expression: "+e)
        }, se.uniqueSort = function (e) {
            var t, n = [], r = 0, i = 0;
            if (l = !d.detectDuplicates, u = !d.sortStable && e.slice(0), e.sort(j), l) {
                while (t = e[i++]) t === e[i] && (r = n.push(i));
                while (r--) e.splice(n[r], 1)
            }
            return u = null, e
        }, o = se.getText = function (e) {
            var t, n = "", r = 0, i = e.nodeType;
            if (i) {
                if (1 === i || 9 === i || 11 === i) {
                    if ("string" == typeof e.textContent) return e.textContent;
                    for (e = e.firstChild; e; e = e.nextSibling) n += o(e)
                } else if (3 === i || 4 === i) return e.nodeValue
            } else while (t = e[r++]) n += o(t);
            return n
        }, (b = se.selectors = {
            cacheLength: 50,
            createPseudo: le,
            match: G,
            attrHandle: {},
            find: {},
            relative: {
                ">": {dir: "parentNode", first: !0},
                " ": {dir: "parentNode"},
                "+": {dir: "previousSibling", first: !0},
                "~": {dir: "previousSibling"}
            },
            preFilter: {
                ATTR: function (e) {
                    return e[1] = e[1].replace(te, ne), e[3] = (e[3] || e[4] || e[5] || "").replace(te, ne), "~=" === e[2] && (e[3] = " "+e[3]+" "), e.slice(0, 4)
                }, CHILD: function (e) {
                    return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || se.error(e[0]), e[4] = +(e[4] ? e[5]+(e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7]+e[8] || "odd" === e[3])) : e[3] && se.error(e[0]), e
                }, PSEUDO: function (e) {
                    var t, n = !e[6] && e[2];
                    return G.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && X.test(n) && (t = h(n, !0)) && (t = n.indexOf(")", n.length-t)-n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                }
            },
            filter: {
                TAG: function (e) {
                    var t = e.replace(te, ne).toLowerCase();
                    return "*" === e ? function () {
                        return !0
                    } : function (e) {
                        return e.nodeName && e.nodeName.toLowerCase() === t
                    }
                }, CLASS: function (e) {
                    var t = m[e+" "];
                    return t || (t = new RegExp("(^|"+M+")"+e+"("+M+"|$)")) && m(e, function (e) {
                        return t.test("string" == typeof e.className && e.className || "undefined" != typeof e.getAttribute && e.getAttribute("class") || "")
                    })
                }, ATTR: function (n, r, i) {
                    return function (e) {
                        var t = se.attr(e, n);
                        return null == t ? "!=" === r : !r || (t += "", "=" === r ? t === i : "!=" === r ? t !== i : "^=" === r ? i && 0 === t.indexOf(i) : "*=" === r ? i && -1 < t.indexOf(i) : "$=" === r ? i && t.slice(-i.length) === i : "~=" === r ? -1 < (" "+t.replace(B, " ")+" ").indexOf(i) : "|=" === r && (t === i || t.slice(0, i.length+1) === i+"-"))
                    }
                }, CHILD: function (h, e, t, g, v) {
                    var y = "nth" !== h.slice(0, 3), m = "last" !== h.slice(-4), x = "of-type" === e;
                    return 1 === g && 0 === v ? function (e) {
                        return !!e.parentNode
                    } : function (e, t, n) {
                        var r, i, o, a, s, u, l = y !== m ? "nextSibling" : "previousSibling", c = e.parentNode,
                            f = x && e.nodeName.toLowerCase(), p = !n && !x, d = !1;
                        if (c) {
                            if (y) {
                                while (l) {
                                    a = e;
                                    while (a = a[l]) if (x ? a.nodeName.toLowerCase() === f : 1 === a.nodeType) return !1;
                                    u = l = "only" === h && !u && "nextSibling"
                                }
                                return !0
                            }
                            if (u = [m ? c.firstChild : c.lastChild], m && p) {
                                d = (s = (r = (i = (o = (a = c)[S] || (a[S] = {}))[a.uniqueID] || (o[a.uniqueID] = {}))[h] || [])[0] === k && r[1]) && r[2], a = s && c.childNodes[s];
                                while (a = ++s && a && a[l] || (d = s = 0) || u.pop()) if (1 === a.nodeType && ++d && a === e) {
                                    i[h] = [k, s, d];
                                    break
                                }
                            } else if (p && (d = s = (r = (i = (o = (a = e)[S] || (a[S] = {}))[a.uniqueID] || (o[a.uniqueID] = {}))[h] || [])[0] === k && r[1]), !1 === d) while (a = ++s && a && a[l] || (d = s = 0) || u.pop()) if ((x ? a.nodeName.toLowerCase() === f : 1 === a.nodeType) && ++d && (p && ((i = (o = a[S] || (a[S] = {}))[a.uniqueID] || (o[a.uniqueID] = {}))[h] = [k, d]), a === e)) break;
                            return (d -= v) === g || d % g == 0 && 0 <= d / g
                        }
                    }
                }, PSEUDO: function (e, o) {
                    var t, a = b.pseudos[e] || b.setFilters[e.toLowerCase()] || se.error("unsupported pseudo: "+e);
                    return a[S] ? a(o) : 1 < a.length ? (t = [e, e, "", o], b.setFilters.hasOwnProperty(e.toLowerCase()) ? le(function (e, t) {
                        var n, r = a(e, o), i = r.length;
                        while (i--) e[n = P(e, r[i])] = !(t[n] = r[i])
                    }) : function (e) {
                        return a(e, 0, t)
                    }) : a
                }
            },
            pseudos: {
                not: le(function (e) {
                    var r = [], i = [], s = f(e.replace($, "$1"));
                    return s[S] ? le(function (e, t, n, r) {
                        var i, o = s(e, null, r, []), a = e.length;
                        while (a--) (i = o[a]) && (e[a] = !(t[a] = i))
                    }) : function (e, t, n) {
                        return r[0] = e, s(r, null, n, i), r[0] = null, !i.pop()
                    }
                }), has: le(function (t) {
                    return function (e) {
                        return 0 < se(t, e).length
                    }
                }), contains: le(function (t) {
                    return t = t.replace(te, ne), function (e) {
                        return -1 < (e.textContent || o(e)).indexOf(t)
                    }
                }), lang: le(function (n) {
                    return V.test(n || "") || se.error("unsupported lang: "+n), n = n.replace(te, ne).toLowerCase(), function (e) {
                        var t;
                        do {
                            if (t = E ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (t = t.toLowerCase()) === n || 0 === t.indexOf(n+"-")
                        } while ((e = e.parentNode) && 1 === e.nodeType);
                        return !1
                    }
                }), target: function (e) {
                    var t = n.location && n.location.hash;
                    return t && t.slice(1) === e.id
                }, root: function (e) {
                    return e === a
                }, focus: function (e) {
                    return e === C.activeElement && (!C.hasFocus || C.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                }, enabled: ge(!1), disabled: ge(!0), checked: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && !!e.checked || "option" === t && !!e.selected
                }, selected: function (e) {
                    return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                }, empty: function (e) {
                    for (e = e.firstChild; e; e = e.nextSibling) if (e.nodeType < 6) return !1;
                    return !0
                }, parent: function (e) {
                    return !b.pseudos.empty(e)
                }, header: function (e) {
                    return J.test(e.nodeName)
                }, input: function (e) {
                    return Q.test(e.nodeName)
                }, button: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && "button" === e.type || "button" === t
                }, text: function (e) {
                    var t;
                    return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                }, first: ve(function () {
                    return [0]
                }), last: ve(function (e, t) {
                    return [t-1]
                }), eq: ve(function (e, t, n) {
                    return [n < 0 ? n+t : n]
                }), even: ve(function (e, t) {
                    for (var n = 0; n < t; n += 2) e.push(n);
                    return e
                }), odd: ve(function (e, t) {
                    for (var n = 1; n < t; n += 2) e.push(n);
                    return e
                }), lt: ve(function (e, t, n) {
                    for (var r = n < 0 ? n+t : t < n ? t : n; 0 <= --r;) e.push(r);
                    return e
                }), gt: ve(function (e, t, n) {
                    for (var r = n < 0 ? n+t : n; ++r < t;) e.push(r);
                    return e
                })
            }
        }).pseudos.nth = b.pseudos.eq, {
            radio: !0,
            checkbox: !0,
            file: !0,
            password: !0,
            image: !0
        }) b.pseudos[e] = de(e);
        for (e in {submit: !0, reset: !0}) b.pseudos[e] = he(e);

        function me() {
        }

        function xe(e) {
            for (var t = 0, n = e.length, r = ""; t < n; t++) r += e[t].value;
            return r
        }

        function be(s, e, t) {
            var u = e.dir, l = e.next, c = l || u, f = t && "parentNode" === c, p = r++;
            return e.first ? function (e, t, n) {
                while (e = e[u]) if (1 === e.nodeType || f) return s(e, t, n);
                return !1
            } : function (e, t, n) {
                var r, i, o, a = [k, p];
                if (n) {
                    while (e = e[u]) if ((1 === e.nodeType || f) && s(e, t, n)) return !0
                } else while (e = e[u]) if (1 === e.nodeType || f) if (i = (o = e[S] || (e[S] = {}))[e.uniqueID] || (o[e.uniqueID] = {}), l && l === e.nodeName.toLowerCase()) e = e[u] || e; else {
                    if ((r = i[c]) && r[0] === k && r[1] === p) return a[2] = r[2];
                    if ((i[c] = a)[2] = s(e, t, n)) return !0
                }
                return !1
            }
        }

        function we(i) {
            return 1 < i.length ? function (e, t, n) {
                var r = i.length;
                while (r--) if (!i[r](e, t, n)) return !1;
                return !0
            } : i[0]
        }

        function Te(e, t, n, r, i) {
            for (var o, a = [], s = 0, u = e.length, l = null != t; s < u; s++) (o = e[s]) && (n && !n(o, r, i) || (a.push(o), l && t.push(s)));
            return a
        }

        function Ce(d, h, g, v, y, e) {
            return v && !v[S] && (v = Ce(v)), y && !y[S] && (y = Ce(y, e)), le(function (e, t, n, r) {
                var i, o, a, s = [], u = [], l = t.length, c = e || function (e, t, n) {
                        for (var r = 0, i = t.length; r < i; r++) se(e, t[r], n);
                        return n
                    }(h || "*", n.nodeType ? [n] : n, []), f = !d || !e && h ? c : Te(c, s, d, n, r),
                    p = g ? y || (e ? d : l || v) ? [] : t : f;
                if (g && g(f, p, n, r), v) {
                    i = Te(p, u), v(i, [], n, r), o = i.length;
                    while (o--) (a = i[o]) && (p[u[o]] = !(f[u[o]] = a))
                }
                if (e) {
                    if (y || d) {
                        if (y) {
                            i = [], o = p.length;
                            while (o--) (a = p[o]) && i.push(f[o] = a);
                            y(null, p = [], i, r)
                        }
                        o = p.length;
                        while (o--) (a = p[o]) && -1 < (i = y ? P(e, a) : s[o]) && (e[i] = !(t[i] = a))
                    }
                } else p = Te(p === t ? p.splice(l, p.length) : p), y ? y(null, t, p, r) : H.apply(t, p)
            })
        }

        function Ee(e) {
            for (var i, t, n, r = e.length, o = b.relative[e[0].type], a = o || b.relative[" "], s = o ? 1 : 0, u = be(function (e) {
                return e === i
            }, a, !0), l = be(function (e) {
                return -1 < P(i, e)
            }, a, !0), c = [function (e, t, n) {
                var r = !o && (n || t !== w) || ((i = t).nodeType ? u(e, t, n) : l(e, t, n));
                return i = null, r
            }]; s < r; s++) if (t = b.relative[e[s].type]) c = [be(we(c), t)]; else {
                if ((t = b.filter[e[s].type].apply(null, e[s].matches))[S]) {
                    for (n = ++s; n < r; n++) if (b.relative[e[n].type]) break;
                    return Ce(1 < s && we(c), 1 < s && xe(e.slice(0, s-1).concat({value: " " === e[s-2].type ? "*" : ""})).replace($, "$1"), t, s < n && Ee(e.slice(s, n)), n < r && Ee(e = e.slice(n)), n < r && xe(e))
                }
                c.push(t)
            }
            return we(c)
        }

        return me.prototype = b.filters = b.pseudos, b.setFilters = new me, h = se.tokenize = function (e, t) {
            var n, r, i, o, a, s, u, l = x[e+" "];
            if (l) return t ? 0 : l.slice(0);
            a = e, s = [], u = b.preFilter;
            while (a) {
                for (o in n && !(r = _.exec(a)) || (r && (a = a.slice(r[0].length) || a), s.push(i = [])), n = !1, (r = z.exec(a)) && (n = r.shift(), i.push({
                    value: n,
                    type: r[0].replace($, " ")
                }), a = a.slice(n.length)), b.filter) !(r = G[o].exec(a)) || u[o] && !(r = u[o](r)) || (n = r.shift(), i.push({
                    value: n,
                    type: o,
                    matches: r
                }), a = a.slice(n.length));
                if (!n) break
            }
            return t ? a.length : a ? se.error(e) : x(e, s).slice(0)
        }, f = se.compile = function (e, t) {
            var n, v, y, m, x, r, i = [], o = [], a = A[e+" "];
            if (!a) {
                t || (t = h(e)), n = t.length;
                while (n--) (a = Ee(t[n]))[S] ? i.push(a) : o.push(a);
                (a = A(e, (v = o, m = 0 < (y = i).length, x = 0 < v.length, r = function (e, t, n, r, i) {
                    var o, a, s, u = 0, l = "0", c = e && [], f = [], p = w, d = e || x && b.find.TAG("*", i),
                        h = k += null == p ? 1 : Math.random() || .1, g = d.length;
                    for (i && (w = t == C || t || i); l !== g && null != (o = d[l]); l++) {
                        if (x && o) {
                            a = 0, t || o.ownerDocument == C || (T(o), n = !E);
                            while (s = v[a++]) if (s(o, t || C, n)) {
                                r.push(o);
                                break
                            }
                            i && (k = h)
                        }
                        m && ((o = !s && o) && u--, e && c.push(o))
                    }
                    if (u += l, m && l !== u) {
                        a = 0;
                        while (s = y[a++]) s(c, f, t, n);
                        if (e) {
                            if (0 < u) while (l--) c[l] || f[l] || (f[l] = q.call(r));
                            f = Te(f)
                        }
                        H.apply(r, f), i && !e && 0 < f.length && 1 < u+y.length && se.uniqueSort(r)
                    }
                    return i && (k = h, w = p), c
                }, m ? le(r) : r))).selector = e
            }
            return a
        }, g = se.select = function (e, t, n, r) {
            var i, o, a, s, u, l = "function" == typeof e && e, c = !r && h(e = l.selector || e);
            if (n = n || [], 1 === c.length) {
                if (2 < (o = c[0] = c[0].slice(0)).length && "ID" === (a = o[0]).type && 9 === t.nodeType && E && b.relative[o[1].type]) {
                    if (!(t = (b.find.ID(a.matches[0].replace(te, ne), t) || [])[0])) return n;
                    l && (t = t.parentNode), e = e.slice(o.shift().value.length)
                }
                i = G.needsContext.test(e) ? 0 : o.length;
                while (i--) {
                    if (a = o[i], b.relative[s = a.type]) break;
                    if ((u = b.find[s]) && (r = u(a.matches[0].replace(te, ne), ee.test(o[0].type) && ye(t.parentNode) || t))) {
                        if (o.splice(i, 1), !(e = r.length && xe(o))) return H.apply(n, r), n;
                        break
                    }
                }
            }
            return (l || f(e, c))(r, t, !E, n, !t || ee.test(e) && ye(t.parentNode) || t), n
        }, d.sortStable = S.split("").sort(j).join("") === S, d.detectDuplicates = !!l, T(), d.sortDetached = ce(function (e) {
            return 1 & e.compareDocumentPosition(C.createElement("fieldset"))
        }), ce(function (e) {
            return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
        }) || fe("type|href|height|width", function (e, t, n) {
            if (!n) return e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
        }), d.attributes && ce(function (e) {
            return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
        }) || fe("value", function (e, t, n) {
            if (!n && "input" === e.nodeName.toLowerCase()) return e.defaultValue
        }), ce(function (e) {
            return null == e.getAttribute("disabled")
        }) || fe(R, function (e, t, n) {
            var r;
            if (!n) return !0 === e[t] ? t.toLowerCase() : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
        }), se
    }(C);
    S.find = d, S.expr = d.selectors, S.expr[":"] = S.expr.pseudos, S.uniqueSort = S.unique = d.uniqueSort, S.text = d.getText, S.isXMLDoc = d.isXML, S.contains = d.contains, S.escapeSelector = d.escape;
    var h = function (e, t, n) {
        var r = [], i = void 0 !== n;
        while ((e = e[t]) && 9 !== e.nodeType) if (1 === e.nodeType) {
            if (i && S(e).is(n)) break;
            r.push(e)
        }
        return r
    }, T = function (e, t) {
        for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
        return n
    }, k = S.expr.match.needsContext;

    function A(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }

    var N = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;

    function j(e, n, r) {
        return m(n) ? S.grep(e, function (e, t) {
            return !!n.call(e, t, e) !== r
        }) : n.nodeType ? S.grep(e, function (e) {
            return e === n !== r
        }) : "string" != typeof n ? S.grep(e, function (e) {
            return -1 < i.call(n, e) !== r
        }) : S.filter(n, e, r)
    }

    S.filter = function (e, t, n) {
        var r = t[0];
        return n && (e = ":not("+e+")"), 1 === t.length && 1 === r.nodeType ? S.find.matchesSelector(r, e) ? [r] : [] : S.find.matches(e, S.grep(t, function (e) {
            return 1 === e.nodeType
        }))
    }, S.fn.extend({
        find: function (e) {
            var t, n, r = this.length, i = this;
            if ("string" != typeof e) return this.pushStack(S(e).filter(function () {
                for (t = 0; t < r; t++) if (S.contains(i[t], this)) return !0
            }));
            for (n = this.pushStack([]), t = 0; t < r; t++) S.find(e, i[t], n);
            return 1 < r ? S.uniqueSort(n) : n
        }, filter: function (e) {
            return this.pushStack(j(this, e || [], !1))
        }, not: function (e) {
            return this.pushStack(j(this, e || [], !0))
        }, is: function (e) {
            return !!j(this, "string" == typeof e && k.test(e) ? S(e) : e || [], !1).length
        }
    });
    var D, q = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (S.fn.init = function (e, t, n) {
        var r, i;
        if (!e) return this;
        if (n = n || D, "string" == typeof e) {
            if (!(r = "<" === e[0] && ">" === e[e.length-1] && 3 <= e.length ? [null, e, null] : q.exec(e)) || !r[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
            if (r[1]) {
                if (t = t instanceof S ? t[0] : t, S.merge(this, S.parseHTML(r[1], t && t.nodeType ? t.ownerDocument || t : E, !0)), N.test(r[1]) && S.isPlainObject(t)) for (r in t) m(this[r]) ? this[r](t[r]) : this.attr(r, t[r]);
                return this
            }
            return (i = E.getElementById(r[2])) && (this[0] = i, this.length = 1), this
        }
        return e.nodeType ? (this[0] = e, this.length = 1, this) : m(e) ? void 0 !== n.ready ? n.ready(e) : e(S) : S.makeArray(e, this)
    }).prototype = S.fn, D = S(E);
    var L = /^(?:parents|prev(?:Until|All))/, H = {children: !0, contents: !0, next: !0, prev: !0};

    function O(e, t) {
        while ((e = e[t]) && 1 !== e.nodeType) ;
        return e
    }

    S.fn.extend({
        has: function (e) {
            var t = S(e, this), n = t.length;
            return this.filter(function () {
                for (var e = 0; e < n; e++) if (S.contains(this, t[e])) return !0
            })
        }, closest: function (e, t) {
            var n, r = 0, i = this.length, o = [], a = "string" != typeof e && S(e);
            if (!k.test(e)) for (; r < i; r++) for (n = this[r]; n && n !== t; n = n.parentNode) if (n.nodeType < 11 && (a ? -1 < a.index(n) : 1 === n.nodeType && S.find.matchesSelector(n, e))) {
                o.push(n);
                break
            }
            return this.pushStack(1 < o.length ? S.uniqueSort(o) : o)
        }, index: function (e) {
            return e ? "string" == typeof e ? i.call(S(e), this[0]) : i.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        }, add: function (e, t) {
            return this.pushStack(S.uniqueSort(S.merge(this.get(), S(e, t))))
        }, addBack: function (e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), S.each({
        parent: function (e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        }, parents: function (e) {
            return h(e, "parentNode")
        }, parentsUntil: function (e, t, n) {
            return h(e, "parentNode", n)
        }, next: function (e) {
            return O(e, "nextSibling")
        }, prev: function (e) {
            return O(e, "previousSibling")
        }, nextAll: function (e) {
            return h(e, "nextSibling")
        }, prevAll: function (e) {
            return h(e, "previousSibling")
        }, nextUntil: function (e, t, n) {
            return h(e, "nextSibling", n)
        }, prevUntil: function (e, t, n) {
            return h(e, "previousSibling", n)
        }, siblings: function (e) {
            return T((e.parentNode || {}).firstChild, e)
        }, children: function (e) {
            return T(e.firstChild)
        }, contents: function (e) {
            return null != e.contentDocument && r(e.contentDocument) ? e.contentDocument : (A(e, "template") && (e = e.content || e), S.merge([], e.childNodes))
        }
    }, function (r, i) {
        S.fn[r] = function (e, t) {
            var n = S.map(this, i, e);
            return "Until" !== r.slice(-5) && (t = e), t && "string" == typeof t && (n = S.filter(t, n)), 1 < this.length && (H[r] || S.uniqueSort(n), L.test(r) && n.reverse()), this.pushStack(n)
        }
    });
    var P = /[^\x20\t\r\n\f]+/g;

    function R(e) {
        return e
    }

    function M(e) {
        throw e
    }

    function I(e, t, n, r) {
        var i;
        try {
            e && m(i = e.promise) ? i.call(e).done(t).fail(n) : e && m(i = e.then) ? i.call(e, t, n) : t.apply(void 0, [e].slice(r))
        } catch (e) {
            n.apply(void 0, [e])
        }
    }

    S.Callbacks = function (r) {
        var e, n;
        r = "string" == typeof r ? (e = r, n = {}, S.each(e.match(P) || [], function (e, t) {
            n[t] = !0
        }), n) : S.extend({}, r);
        var i, t, o, a, s = [], u = [], l = -1, c = function () {
            for (a = a || r.once, o = i = !0; u.length; l = -1) {
                t = u.shift();
                while (++l < s.length) !1 === s[l].apply(t[0], t[1]) && r.stopOnFalse && (l = s.length, t = !1)
            }
            r.memory || (t = !1), i = !1, a && (s = t ? [] : "")
        }, f = {
            add: function () {
                return s && (t && !i && (l = s.length-1, u.push(t)), function n(e) {
                    S.each(e, function (e, t) {
                        m(t) ? r.unique && f.has(t) || s.push(t) : t && t.length && "string" !== w(t) && n(t)
                    })
                }(arguments), t && !i && c()), this
            }, remove: function () {
                return S.each(arguments, function (e, t) {
                    var n;
                    while (-1 < (n = S.inArray(t, s, n))) s.splice(n, 1), n <= l && l--
                }), this
            }, has: function (e) {
                return e ? -1 < S.inArray(e, s) : 0 < s.length
            }, empty: function () {
                return s && (s = []), this
            }, disable: function () {
                return a = u = [], s = t = "", this
            }, disabled: function () {
                return !s
            }, lock: function () {
                return a = u = [], t || i || (s = t = ""), this
            }, locked: function () {
                return !!a
            }, fireWith: function (e, t) {
                return a || (t = [e, (t = t || []).slice ? t.slice() : t], u.push(t), i || c()), this
            }, fire: function () {
                return f.fireWith(this, arguments), this
            }, fired: function () {
                return !!o
            }
        };
        return f
    }, S.extend({
        Deferred: function (e) {
            var o = [["notify", "progress", S.Callbacks("memory"), S.Callbacks("memory"), 2], ["resolve", "done", S.Callbacks("once memory"), S.Callbacks("once memory"), 0, "resolved"], ["reject", "fail", S.Callbacks("once memory"), S.Callbacks("once memory"), 1, "rejected"]],
                i = "pending", a = {
                    state: function () {
                        return i
                    }, always: function () {
                        return s.done(arguments).fail(arguments), this
                    }, "catch": function (e) {
                        return a.then(null, e)
                    }, pipe: function () {
                        var i = arguments;
                        return S.Deferred(function (r) {
                            S.each(o, function (e, t) {
                                var n = m(i[t[4]]) && i[t[4]];
                                s[t[1]](function () {
                                    var e = n && n.apply(this, arguments);
                                    e && m(e.promise) ? e.promise().progress(r.notify).done(r.resolve).fail(r.reject) : r[t[0]+"With"](this, n ? [e] : arguments)
                                })
                            }), i = null
                        }).promise()
                    }, then: function (t, n, r) {
                        var u = 0;

                        function l(i, o, a, s) {
                            return function () {
                                var n = this, r = arguments, e = function () {
                                    var e, t;
                                    if (!(i < u)) {
                                        if ((e = a.apply(n, r)) === o.promise()) throw new TypeError("Thenable self-resolution");
                                        t = e && ("object" == typeof e || "function" == typeof e) && e.then, m(t) ? s ? t.call(e, l(u, o, R, s), l(u, o, M, s)) : (u++, t.call(e, l(u, o, R, s), l(u, o, M, s), l(u, o, R, o.notifyWith))) : (a !== R && (n = void 0, r = [e]), (s || o.resolveWith)(n, r))
                                    }
                                }, t = s ? e : function () {
                                    try {
                                        e()
                                    } catch (e) {
                                        S.Deferred.exceptionHook && S.Deferred.exceptionHook(e, t.stackTrace), u <= i+1 && (a !== M && (n = void 0, r = [e]), o.rejectWith(n, r))
                                    }
                                };
                                i ? t() : (S.Deferred.getStackHook && (t.stackTrace = S.Deferred.getStackHook()), C.setTimeout(t))
                            }
                        }

                        return S.Deferred(function (e) {
                            o[0][3].add(l(0, e, m(r) ? r : R, e.notifyWith)), o[1][3].add(l(0, e, m(t) ? t : R)), o[2][3].add(l(0, e, m(n) ? n : M))
                        }).promise()
                    }, promise: function (e) {
                        return null != e ? S.extend(e, a) : a
                    }
                }, s = {};
            return S.each(o, function (e, t) {
                var n = t[2], r = t[5];
                a[t[1]] = n.add, r && n.add(function () {
                    i = r
                }, o[3-e][2].disable, o[3-e][3].disable, o[0][2].lock, o[0][3].lock), n.add(t[3].fire), s[t[0]] = function () {
                    return s[t[0]+"With"](this === s ? void 0 : this, arguments), this
                }, s[t[0]+"With"] = n.fireWith
            }), a.promise(s), e && e.call(s, s), s
        }, when: function (e) {
            var n = arguments.length, t = n, r = Array(t), i = s.call(arguments), o = S.Deferred(), a = function (t) {
                return function (e) {
                    r[t] = this, i[t] = 1 < arguments.length ? s.call(arguments) : e, --n || o.resolveWith(r, i)
                }
            };
            if (n <= 1 && (I(e, o.done(a(t)).resolve, o.reject, !n), "pending" === o.state() || m(i[t] && i[t].then))) return o.then();
            while (t--) I(i[t], a(t), o.reject);
            return o.promise()
        }
    });
    var W = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    S.Deferred.exceptionHook = function (e, t) {
        C.console && C.console.warn && e && W.test(e.name) && C.console.warn("jQuery.Deferred exception: "+e.message, e.stack, t)
    }, S.readyException = function (e) {
        C.setTimeout(function () {
            throw e
        })
    };
    var F = S.Deferred();

    function B() {
        E.removeEventListener("DOMContentLoaded", B), C.removeEventListener("load", B), S.ready()
    }

    S.fn.ready = function (e) {
        return F.then(e)["catch"](function (e) {
            S.readyException(e)
        }), this
    }, S.extend({
        isReady: !1, readyWait: 1, ready: function (e) {
            (!0 === e ? --S.readyWait : S.isReady) || (S.isReady = !0) !== e && 0 < --S.readyWait || F.resolveWith(E, [S])
        }
    }), S.ready.then = F.then, "complete" === E.readyState || "loading" !== E.readyState && !E.documentElement.doScroll ? C.setTimeout(S.ready) : (E.addEventListener("DOMContentLoaded", B), C.addEventListener("load", B));
    var $ = function (e, t, n, r, i, o, a) {
        var s = 0, u = e.length, l = null == n;
        if ("object" === w(n)) for (s in i = !0, n) $(e, t, s, n[s], !0, o, a); else if (void 0 !== r && (i = !0, m(r) || (a = !0), l && (a ? (t.call(e, r), t = null) : (l = t, t = function (e, t, n) {
            return l.call(S(e), n)
        })), t)) for (; s < u; s++) t(e[s], n, a ? r : r.call(e[s], s, t(e[s], n)));
        return i ? e : l ? t.call(e) : u ? t(e[0], n) : o
    }, _ = /^-ms-/, z = /-([a-z])/g;

    function U(e, t) {
        return t.toUpperCase()
    }

    function X(e) {
        return e.replace(_, "ms-").replace(z, U)
    }

    var V = function (e) {
        return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
    };

    function G() {
        this.expando = S.expando+G.uid++
    }

    G.uid = 1, G.prototype = {
        cache: function (e) {
            var t = e[this.expando];
            return t || (t = {}, V(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
                value: t,
                configurable: !0
            }))), t
        }, set: function (e, t, n) {
            var r, i = this.cache(e);
            if ("string" == typeof t) i[X(t)] = n; else for (r in t) i[X(r)] = t[r];
            return i
        }, get: function (e, t) {
            return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][X(t)]
        }, access: function (e, t, n) {
            return void 0 === t || t && "string" == typeof t && void 0 === n ? this.get(e, t) : (this.set(e, t, n), void 0 !== n ? n : t)
        }, remove: function (e, t) {
            var n, r = e[this.expando];
            if (void 0 !== r) {
                if (void 0 !== t) {
                    n = (t = Array.isArray(t) ? t.map(X) : (t = X(t)) in r ? [t] : t.match(P) || []).length;
                    while (n--) delete r[t[n]]
                }
                (void 0 === t || S.isEmptyObject(r)) && (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
            }
        }, hasData: function (e) {
            var t = e[this.expando];
            return void 0 !== t && !S.isEmptyObject(t)
        }
    };
    var Y = new G, Q = new G, J = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/, K = /[A-Z]/g;

    function Z(e, t, n) {
        var r, i;
        if (void 0 === n && 1 === e.nodeType) if (r = "data-"+t.replace(K, "-$&").toLowerCase(), "string" == typeof (n = e.getAttribute(r))) {
            try {
                n = "true" === (i = n) || "false" !== i && ("null" === i ? null : i === +i+"" ? +i : J.test(i) ? JSON.parse(i) : i)
            } catch (e) {
            }
            Q.set(e, t, n)
        } else n = void 0;
        return n
    }

    S.extend({
        hasData: function (e) {
            return Q.hasData(e) || Y.hasData(e)
        }, data: function (e, t, n) {
            return Q.access(e, t, n)
        }, removeData: function (e, t) {
            Q.remove(e, t)
        }, _data: function (e, t, n) {
            return Y.access(e, t, n)
        }, _removeData: function (e, t) {
            Y.remove(e, t)
        }
    }), S.fn.extend({
        data: function (n, e) {
            var t, r, i, o = this[0], a = o && o.attributes;
            if (void 0 === n) {
                if (this.length && (i = Q.get(o), 1 === o.nodeType && !Y.get(o, "hasDataAttrs"))) {
                    t = a.length;
                    while (t--) a[t] && 0 === (r = a[t].name).indexOf("data-") && (r = X(r.slice(5)), Z(o, r, i[r]));
                    Y.set(o, "hasDataAttrs", !0)
                }
                return i
            }
            return "object" == typeof n ? this.each(function () {
                Q.set(this, n)
            }) : $(this, function (e) {
                var t;
                if (o && void 0 === e) return void 0 !== (t = Q.get(o, n)) ? t : void 0 !== (t = Z(o, n)) ? t : void 0;
                this.each(function () {
                    Q.set(this, n, e)
                })
            }, null, e, 1 < arguments.length, null, !0)
        }, removeData: function (e) {
            return this.each(function () {
                Q.remove(this, e)
            })
        }
    }), S.extend({
        queue: function (e, t, n) {
            var r;
            if (e) return t = (t || "fx")+"queue", r = Y.get(e, t), n && (!r || Array.isArray(n) ? r = Y.access(e, t, S.makeArray(n)) : r.push(n)), r || []
        }, dequeue: function (e, t) {
            t = t || "fx";
            var n = S.queue(e, t), r = n.length, i = n.shift(), o = S._queueHooks(e, t);
            "inprogress" === i && (i = n.shift(), r--), i && ("fx" === t && n.unshift("inprogress"), delete o.stop, i.call(e, function () {
                S.dequeue(e, t)
            }, o)), !r && o && o.empty.fire()
        }, _queueHooks: function (e, t) {
            var n = t+"queueHooks";
            return Y.get(e, n) || Y.access(e, n, {
                empty: S.Callbacks("once memory").add(function () {
                    Y.remove(e, [t+"queue", n])
                })
            })
        }
    }), S.fn.extend({
        queue: function (t, n) {
            var e = 2;
            return "string" != typeof t && (n = t, t = "fx", e--), arguments.length < e ? S.queue(this[0], t) : void 0 === n ? this : this.each(function () {
                var e = S.queue(this, t, n);
                S._queueHooks(this, t), "fx" === t && "inprogress" !== e[0] && S.dequeue(this, t)
            })
        }, dequeue: function (e) {
            return this.each(function () {
                S.dequeue(this, e)
            })
        }, clearQueue: function (e) {
            return this.queue(e || "fx", [])
        }, promise: function (e, t) {
            var n, r = 1, i = S.Deferred(), o = this, a = this.length, s = function () {
                --r || i.resolveWith(o, [o])
            };
            "string" != typeof e && (t = e, e = void 0), e = e || "fx";
            while (a--) (n = Y.get(o[a], e+"queueHooks")) && n.empty && (r++, n.empty.add(s));
            return s(), i.promise(t)
        }
    });
    var ee = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, te = new RegExp("^(?:([+-])=|)("+ee+")([a-z%]*)$", "i"),
        ne = ["Top", "Right", "Bottom", "Left"], re = E.documentElement, ie = function (e) {
            return S.contains(e.ownerDocument, e)
        }, oe = {composed: !0};
    re.getRootNode && (ie = function (e) {
        return S.contains(e.ownerDocument, e) || e.getRootNode(oe) === e.ownerDocument
    });
    var ae = function (e, t) {
        return "none" === (e = t || e).style.display || "" === e.style.display && ie(e) && "none" === S.css(e, "display")
    };

    function se(e, t, n, r) {
        var i, o, a = 20, s = r ? function () {
                return r.cur()
            } : function () {
                return S.css(e, t, "")
            }, u = s(), l = n && n[3] || (S.cssNumber[t] ? "" : "px"),
            c = e.nodeType && (S.cssNumber[t] || "px" !== l && +u) && te.exec(S.css(e, t));
        if (c && c[3] !== l) {
            u /= 2, l = l || c[3], c = +u || 1;
            while (a--) S.style(e, t, c+l), (1-o) * (1-(o = s() / u || .5)) <= 0 && (a = 0), c /= o;
            c *= 2, S.style(e, t, c+l), n = n || []
        }
        return n && (c = +c || +u || 0, i = n[1] ? c+(n[1]+1) * n[2] : +n[2], r && (r.unit = l, r.start = c, r.end = i)), i
    }

    var ue = {};

    function le(e, t) {
        for (var n, r, i, o, a, s, u, l = [], c = 0, f = e.length; c < f; c++) (r = e[c]).style && (n = r.style.display, t ? ("none" === n && (l[c] = Y.get(r, "display") || null, l[c] || (r.style.display = "")), "" === r.style.display && ae(r) && (l[c] = (u = a = o = void 0, a = (i = r).ownerDocument, s = i.nodeName, (u = ue[s]) || (o = a.body.appendChild(a.createElement(s)), u = S.css(o, "display"), o.parentNode.removeChild(o), "none" === u && (u = "block"), ue[s] = u)))) : "none" !== n && (l[c] = "none", Y.set(r, "display", n)));
        for (c = 0; c < f; c++) null != l[c] && (e[c].style.display = l[c]);
        return e
    }

    S.fn.extend({
        show: function () {
            return le(this, !0)
        }, hide: function () {
            return le(this)
        }, toggle: function (e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function () {
                ae(this) ? S(this).show() : S(this).hide()
            })
        }
    });
    var ce, fe, pe = /^(?:checkbox|radio)$/i, de = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
        he = /^$|^module$|\/(?:java|ecma)script/i;
    ce = E.createDocumentFragment().appendChild(E.createElement("div")), (fe = E.createElement("input")).setAttribute("type", "radio"), fe.setAttribute("checked", "checked"), fe.setAttribute("name", "t"), ce.appendChild(fe), y.checkClone = ce.cloneNode(!0).cloneNode(!0).lastChild.checked, ce.innerHTML = "<textarea>x</textarea>", y.noCloneChecked = !!ce.cloneNode(!0).lastChild.defaultValue, ce.innerHTML = "<option></option>", y.option = !!ce.lastChild;
    var ge = {
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""]
    };

    function ve(e, t) {
        var n;
        return n = "undefined" != typeof e.getElementsByTagName ? e.getElementsByTagName(t || "*") : "undefined" != typeof e.querySelectorAll ? e.querySelectorAll(t || "*") : [], void 0 === t || t && A(e, t) ? S.merge([e], n) : n
    }

    function ye(e, t) {
        for (var n = 0, r = e.length; n < r; n++) Y.set(e[n], "globalEval", !t || Y.get(t[n], "globalEval"))
    }

    ge.tbody = ge.tfoot = ge.colgroup = ge.caption = ge.thead, ge.th = ge.td, y.option || (ge.optgroup = ge.option = [1, "<select multiple='multiple'>", "</select>"]);
    var me = /<|&#?\w+;/;

    function xe(e, t, n, r, i) {
        for (var o, a, s, u, l, c, f = t.createDocumentFragment(), p = [], d = 0, h = e.length; d < h; d++) if ((o = e[d]) || 0 === o) if ("object" === w(o)) S.merge(p, o.nodeType ? [o] : o); else if (me.test(o)) {
            a = a || f.appendChild(t.createElement("div")), s = (de.exec(o) || ["", ""])[1].toLowerCase(), u = ge[s] || ge._default, a.innerHTML = u[1]+S.htmlPrefilter(o)+u[2], c = u[0];
            while (c--) a = a.lastChild;
            S.merge(p, a.childNodes), (a = f.firstChild).textContent = ""
        } else p.push(t.createTextNode(o));
        f.textContent = "", d = 0;
        while (o = p[d++]) if (r && -1 < S.inArray(o, r)) i && i.push(o); else if (l = ie(o), a = ve(f.appendChild(o), "script"), l && ye(a), n) {
            c = 0;
            while (o = a[c++]) he.test(o.type || "") && n.push(o)
        }
        return f
    }

    var be = /^([^.]*)(?:\.(.+)|)/;

    function we() {
        return !0
    }

    function Te() {
        return !1
    }

    function Ce(e, t) {
        return e === function () {
            try {
                return E.activeElement
            } catch (e) {
            }
        }() == ("focus" === t)
    }

    function Ee(e, t, n, r, i, o) {
        var a, s;
        if ("object" == typeof t) {
            for (s in "string" != typeof n && (r = r || n, n = void 0), t) Ee(e, s, n, r, t[s], o);
            return e
        }
        if (null == r && null == i ? (i = n, r = n = void 0) : null == i && ("string" == typeof n ? (i = r, r = void 0) : (i = r, r = n, n = void 0)), !1 === i) i = Te; else if (!i) return e;
        return 1 === o && (a = i, (i = function (e) {
            return S().off(e), a.apply(this, arguments)
        }).guid = a.guid || (a.guid = S.guid++)), e.each(function () {
            S.event.add(this, t, i, r, n)
        })
    }

    function Se(e, i, o) {
        o ? (Y.set(e, i, !1), S.event.add(e, i, {
            namespace: !1, handler: function (e) {
                var t, n, r = Y.get(this, i);
                if (1 & e.isTrigger && this[i]) {
                    if (r.length) (S.event.special[i] || {}).delegateType && e.stopPropagation(); else if (r = s.call(arguments), Y.set(this, i, r), t = o(this, i), this[i](), r !== (n = Y.get(this, i)) || t ? Y.set(this, i, !1) : n = {}, r !== n) return e.stopImmediatePropagation(), e.preventDefault(), n && n.value
                } else r.length && (Y.set(this, i, {value: S.event.trigger(S.extend(r[0], S.Event.prototype), r.slice(1), this)}), e.stopImmediatePropagation())
            }
        })) : void 0 === Y.get(e, i) && S.event.add(e, i, we)
    }

    S.event = {
        global: {}, add: function (t, e, n, r, i) {
            var o, a, s, u, l, c, f, p, d, h, g, v = Y.get(t);
            if (V(t)) {
                n.handler && (n = (o = n).handler, i = o.selector), i && S.find.matchesSelector(re, i), n.guid || (n.guid = S.guid++), (u = v.events) || (u = v.events = Object.create(null)), (a = v.handle) || (a = v.handle = function (e) {
                    return "undefined" != typeof S && S.event.triggered !== e.type ? S.event.dispatch.apply(t, arguments) : void 0
                }), l = (e = (e || "").match(P) || [""]).length;
                while (l--) d = g = (s = be.exec(e[l]) || [])[1], h = (s[2] || "").split(".").sort(), d && (f = S.event.special[d] || {}, d = (i ? f.delegateType : f.bindType) || d, f = S.event.special[d] || {}, c = S.extend({
                    type: d,
                    origType: g,
                    data: r,
                    handler: n,
                    guid: n.guid,
                    selector: i,
                    needsContext: i && S.expr.match.needsContext.test(i),
                    namespace: h.join(".")
                }, o), (p = u[d]) || ((p = u[d] = []).delegateCount = 0, f.setup && !1 !== f.setup.call(t, r, h, a) || t.addEventListener && t.addEventListener(d, a)), f.add && (f.add.call(t, c), c.handler.guid || (c.handler.guid = n.guid)), i ? p.splice(p.delegateCount++, 0, c) : p.push(c), S.event.global[d] = !0)
            }
        }, remove: function (e, t, n, r, i) {
            var o, a, s, u, l, c, f, p, d, h, g, v = Y.hasData(e) && Y.get(e);
            if (v && (u = v.events)) {
                l = (t = (t || "").match(P) || [""]).length;
                while (l--) if (d = g = (s = be.exec(t[l]) || [])[1], h = (s[2] || "").split(".").sort(), d) {
                    f = S.event.special[d] || {}, p = u[d = (r ? f.delegateType : f.bindType) || d] || [], s = s[2] && new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)"), a = o = p.length;
                    while (o--) c = p[o], !i && g !== c.origType || n && n.guid !== c.guid || s && !s.test(c.namespace) || r && r !== c.selector && ("**" !== r || !c.selector) || (p.splice(o, 1), c.selector && p.delegateCount--, f.remove && f.remove.call(e, c));
                    a && !p.length && (f.teardown && !1 !== f.teardown.call(e, h, v.handle) || S.removeEvent(e, d, v.handle), delete u[d])
                } else for (d in u) S.event.remove(e, d+t[l], n, r, !0);
                S.isEmptyObject(u) && Y.remove(e, "handle events")
            }
        }, dispatch: function (e) {
            var t, n, r, i, o, a, s = new Array(arguments.length), u = S.event.fix(e),
                l = (Y.get(this, "events") || Object.create(null))[u.type] || [], c = S.event.special[u.type] || {};
            for (s[0] = u, t = 1; t < arguments.length; t++) s[t] = arguments[t];
            if (u.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, u)) {
                a = S.event.handlers.call(this, u, l), t = 0;
                while ((i = a[t++]) && !u.isPropagationStopped()) {
                    u.currentTarget = i.elem, n = 0;
                    while ((o = i.handlers[n++]) && !u.isImmediatePropagationStopped()) u.rnamespace && !1 !== o.namespace && !u.rnamespace.test(o.namespace) || (u.handleObj = o, u.data = o.data, void 0 !== (r = ((S.event.special[o.origType] || {}).handle || o.handler).apply(i.elem, s)) && !1 === (u.result = r) && (u.preventDefault(), u.stopPropagation()))
                }
                return c.postDispatch && c.postDispatch.call(this, u), u.result
            }
        }, handlers: function (e, t) {
            var n, r, i, o, a, s = [], u = t.delegateCount, l = e.target;
            if (u && l.nodeType && !("click" === e.type && 1 <= e.button)) for (; l !== this; l = l.parentNode || this) if (1 === l.nodeType && ("click" !== e.type || !0 !== l.disabled)) {
                for (o = [], a = {}, n = 0; n < u; n++) void 0 === a[i = (r = t[n]).selector+" "] && (a[i] = r.needsContext ? -1 < S(i, this).index(l) : S.find(i, this, null, [l]).length), a[i] && o.push(r);
                o.length && s.push({elem: l, handlers: o})
            }
            return l = this, u < t.length && s.push({elem: l, handlers: t.slice(u)}), s
        }, addProp: function (t, e) {
            Object.defineProperty(S.Event.prototype, t, {
                enumerable: !0, configurable: !0, get: m(e) ? function () {
                    if (this.originalEvent) return e(this.originalEvent)
                } : function () {
                    if (this.originalEvent) return this.originalEvent[t]
                }, set: function (e) {
                    Object.defineProperty(this, t, {enumerable: !0, configurable: !0, writable: !0, value: e})
                }
            })
        }, fix: function (e) {
            return e[S.expando] ? e : new S.Event(e)
        }, special: {
            load: {noBubble: !0}, click: {
                setup: function (e) {
                    var t = this || e;
                    return pe.test(t.type) && t.click && A(t, "input") && Se(t, "click", we), !1
                }, trigger: function (e) {
                    var t = this || e;
                    return pe.test(t.type) && t.click && A(t, "input") && Se(t, "click"), !0
                }, _default: function (e) {
                    var t = e.target;
                    return pe.test(t.type) && t.click && A(t, "input") && Y.get(t, "click") || A(t, "a")
                }
            }, beforeunload: {
                postDispatch: function (e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        }
    }, S.removeEvent = function (e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n)
    }, S.Event = function (e, t) {
        if (!(this instanceof S.Event)) return new S.Event(e, t);
        e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? we : Te, this.target = e.target && 3 === e.target.nodeType ? e.target.parentNode : e.target, this.currentTarget = e.currentTarget, this.relatedTarget = e.relatedTarget) : this.type = e, t && S.extend(this, t), this.timeStamp = e && e.timeStamp || Date.now(), this[S.expando] = !0
    }, S.Event.prototype = {
        constructor: S.Event,
        isDefaultPrevented: Te,
        isPropagationStopped: Te,
        isImmediatePropagationStopped: Te,
        isSimulated: !1,
        preventDefault: function () {
            var e = this.originalEvent;
            this.isDefaultPrevented = we, e && !this.isSimulated && e.preventDefault()
        },
        stopPropagation: function () {
            var e = this.originalEvent;
            this.isPropagationStopped = we, e && !this.isSimulated && e.stopPropagation()
        },
        stopImmediatePropagation: function () {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = we, e && !this.isSimulated && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, S.each({
        altKey: !0,
        bubbles: !0,
        cancelable: !0,
        changedTouches: !0,
        ctrlKey: !0,
        detail: !0,
        eventPhase: !0,
        metaKey: !0,
        pageX: !0,
        pageY: !0,
        shiftKey: !0,
        view: !0,
        "char": !0,
        code: !0,
        charCode: !0,
        key: !0,
        keyCode: !0,
        button: !0,
        buttons: !0,
        clientX: !0,
        clientY: !0,
        offsetX: !0,
        offsetY: !0,
        pointerId: !0,
        pointerType: !0,
        screenX: !0,
        screenY: !0,
        targetTouches: !0,
        toElement: !0,
        touches: !0,
        which: !0
    }, S.event.addProp), S.each({focus: "focusin", blur: "focusout"}, function (e, t) {
        S.event.special[e] = {
            setup: function () {
                return Se(this, e, Ce), !1
            }, trigger: function () {
                return Se(this, e), !0
            }, _default: function () {
                return !0
            }, delegateType: t
        }
    }), S.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, function (e, i) {
        S.event.special[e] = {
            delegateType: i, bindType: i, handle: function (e) {
                var t, n = e.relatedTarget, r = e.handleObj;
                return n && (n === this || S.contains(this, n)) || (e.type = r.origType, t = r.handler.apply(this, arguments), e.type = i), t
            }
        }
    }), S.fn.extend({
        on: function (e, t, n, r) {
            return Ee(this, e, t, n, r)
        }, one: function (e, t, n, r) {
            return Ee(this, e, t, n, r, 1)
        }, off: function (e, t, n) {
            var r, i;
            if (e && e.preventDefault && e.handleObj) return r = e.handleObj, S(e.delegateTarget).off(r.namespace ? r.origType+"."+r.namespace : r.origType, r.selector, r.handler), this;
            if ("object" == typeof e) {
                for (i in e) this.off(i, t, e[i]);
                return this
            }
            return !1 !== t && "function" != typeof t || (n = t, t = void 0), !1 === n && (n = Te), this.each(function () {
                S.event.remove(this, e, n, t)
            })
        }
    });
    var ke = /<script|<style|<link/i, Ae = /checked\s*(?:[^=]|=\s*.checked.)/i,
        Ne = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

    function je(e, t) {
        return A(e, "table") && A(11 !== t.nodeType ? t : t.firstChild, "tr") && S(e).children("tbody")[0] || e
    }

    function De(e) {
        return e.type = (null !== e.getAttribute("type"))+"/"+e.type, e
    }

    function qe(e) {
        return "true/" === (e.type || "").slice(0, 5) ? e.type = e.type.slice(5) : e.removeAttribute("type"), e
    }

    function Le(e, t) {
        var n, r, i, o, a, s;
        if (1 === t.nodeType) {
            if (Y.hasData(e) && (s = Y.get(e).events)) for (i in Y.remove(t, "handle events"), s) for (n = 0, r = s[i].length; n < r; n++) S.event.add(t, i, s[i][n]);
            Q.hasData(e) && (o = Q.access(e), a = S.extend({}, o), Q.set(t, a))
        }
    }

    function He(n, r, i, o) {
        r = g(r);
        var e, t, a, s, u, l, c = 0, f = n.length, p = f-1, d = r[0], h = m(d);
        if (h || 1 < f && "string" == typeof d && !y.checkClone && Ae.test(d)) return n.each(function (e) {
            var t = n.eq(e);
            h && (r[0] = d.call(this, e, t.html())), He(t, r, i, o)
        });
        if (f && (t = (e = xe(r, n[0].ownerDocument, !1, n, o)).firstChild, 1 === e.childNodes.length && (e = t), t || o)) {
            for (s = (a = S.map(ve(e, "script"), De)).length; c < f; c++) u = e, c !== p && (u = S.clone(u, !0, !0), s && S.merge(a, ve(u, "script"))), i.call(n[c], u, c);
            if (s) for (l = a[a.length-1].ownerDocument, S.map(a, qe), c = 0; c < s; c++) u = a[c], he.test(u.type || "") && !Y.access(u, "globalEval") && S.contains(l, u) && (u.src && "module" !== (u.type || "").toLowerCase() ? S._evalUrl && !u.noModule && S._evalUrl(u.src, {nonce: u.nonce || u.getAttribute("nonce")}, l) : b(u.textContent.replace(Ne, ""), u, l))
        }
        return n
    }

    function Oe(e, t, n) {
        for (var r, i = t ? S.filter(t, e) : e, o = 0; null != (r = i[o]); o++) n || 1 !== r.nodeType || S.cleanData(ve(r)), r.parentNode && (n && ie(r) && ye(ve(r, "script")), r.parentNode.removeChild(r));
        return e
    }

    S.extend({
        htmlPrefilter: function (e) {
            return e
        }, clone: function (e, t, n) {
            var r, i, o, a, s, u, l, c = e.cloneNode(!0), f = ie(e);
            if (!(y.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || S.isXMLDoc(e))) for (a = ve(c), r = 0, i = (o = ve(e)).length; r < i; r++) s = o[r], u = a[r], void 0, "input" === (l = u.nodeName.toLowerCase()) && pe.test(s.type) ? u.checked = s.checked : "input" !== l && "textarea" !== l || (u.defaultValue = s.defaultValue);
            if (t) if (n) for (o = o || ve(e), a = a || ve(c), r = 0, i = o.length; r < i; r++) Le(o[r], a[r]); else Le(e, c);
            return 0 < (a = ve(c, "script")).length && ye(a, !f && ve(e, "script")), c
        }, cleanData: function (e) {
            for (var t, n, r, i = S.event.special, o = 0; void 0 !== (n = e[o]); o++) if (V(n)) {
                if (t = n[Y.expando]) {
                    if (t.events) for (r in t.events) i[r] ? S.event.remove(n, r) : S.removeEvent(n, r, t.handle);
                    n[Y.expando] = void 0
                }
                n[Q.expando] && (n[Q.expando] = void 0)
            }
        }
    }), S.fn.extend({
        detach: function (e) {
            return Oe(this, e, !0)
        }, remove: function (e) {
            return Oe(this, e)
        }, text: function (e) {
            return $(this, function (e) {
                return void 0 === e ? S.text(this) : this.empty().each(function () {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = e)
                })
            }, null, e, arguments.length)
        }, append: function () {
            return He(this, arguments, function (e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || je(this, e).appendChild(e)
            })
        }, prepend: function () {
            return He(this, arguments, function (e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = je(this, e);
                    t.insertBefore(e, t.firstChild)
                }
            })
        }, before: function () {
            return He(this, arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        }, after: function () {
            return He(this, arguments, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        }, empty: function () {
            for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (S.cleanData(ve(e, !1)), e.textContent = "");
            return this
        }, clone: function (e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map(function () {
                return S.clone(this, e, t)
            })
        }, html: function (e) {
            return $(this, function (e) {
                var t = this[0] || {}, n = 0, r = this.length;
                if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
                if ("string" == typeof e && !ke.test(e) && !ge[(de.exec(e) || ["", ""])[1].toLowerCase()]) {
                    e = S.htmlPrefilter(e);
                    try {
                        for (; n < r; n++) 1 === (t = this[n] || {}).nodeType && (S.cleanData(ve(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (e) {
                    }
                }
                t && this.empty().append(e)
            }, null, e, arguments.length)
        }, replaceWith: function () {
            var n = [];
            return He(this, arguments, function (e) {
                var t = this.parentNode;
                S.inArray(this, n) < 0 && (S.cleanData(ve(this)), t && t.replaceChild(e, this))
            }, n)
        }
    }), S.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function (e, a) {
        S.fn[e] = function (e) {
            for (var t, n = [], r = S(e), i = r.length-1, o = 0; o <= i; o++) t = o === i ? this : this.clone(!0), S(r[o])[a](t), u.apply(n, t.get());
            return this.pushStack(n)
        }
    });
    var Pe = new RegExp("^("+ee+")(?!px)[a-z%]+$", "i"), Re = function (e) {
        var t = e.ownerDocument.defaultView;
        return t && t.opener || (t = C), t.getComputedStyle(e)
    }, Me = function (e, t, n) {
        var r, i, o = {};
        for (i in t) o[i] = e.style[i], e.style[i] = t[i];
        for (i in r = n.call(e), t) e.style[i] = o[i];
        return r
    }, Ie = new RegExp(ne.join("|"), "i");

    function We(e, t, n) {
        var r, i, o, a, s = e.style;
        return (n = n || Re(e)) && ("" !== (a = n.getPropertyValue(t) || n[t]) || ie(e) || (a = S.style(e, t)), !y.pixelBoxStyles() && Pe.test(a) && Ie.test(t) && (r = s.width, i = s.minWidth, o = s.maxWidth, s.minWidth = s.maxWidth = s.width = a, a = n.width, s.width = r, s.minWidth = i, s.maxWidth = o)), void 0 !== a ? a+"" : a
    }

    function Fe(e, t) {
        return {
            get: function () {
                if (!e()) return (this.get = t).apply(this, arguments);
                delete this.get
            }
        }
    }

    !function () {
        function e() {
            if (l) {
                u.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", l.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", re.appendChild(u).appendChild(l);
                var e = C.getComputedStyle(l);
                n = "1%" !== e.top, s = 12 === t(e.marginLeft), l.style.right = "60%", o = 36 === t(e.right), r = 36 === t(e.width), l.style.position = "absolute", i = 12 === t(l.offsetWidth / 3), re.removeChild(u), l = null
            }
        }

        function t(e) {
            return Math.round(parseFloat(e))
        }

        var n, r, i, o, a, s, u = E.createElement("div"), l = E.createElement("div");
        l.style && (l.style.backgroundClip = "content-box", l.cloneNode(!0).style.backgroundClip = "", y.clearCloneStyle = "content-box" === l.style.backgroundClip, S.extend(y, {
            boxSizingReliable: function () {
                return e(), r
            }, pixelBoxStyles: function () {
                return e(), o
            }, pixelPosition: function () {
                return e(), n
            }, reliableMarginLeft: function () {
                return e(), s
            }, scrollboxSize: function () {
                return e(), i
            }, reliableTrDimensions: function () {
                var e, t, n, r;
                return null == a && (e = E.createElement("table"), t = E.createElement("tr"), n = E.createElement("div"), e.style.cssText = "position:absolute;left:-11111px;border-collapse:separate", t.style.cssText = "border:1px solid", t.style.height = "1px", n.style.height = "9px", n.style.display = "block", re.appendChild(e).appendChild(t).appendChild(n), r = C.getComputedStyle(t), a = parseInt(r.height, 10)+parseInt(r.borderTopWidth, 10)+parseInt(r.borderBottomWidth, 10) === t.offsetHeight, re.removeChild(e)), a
            }
        }))
    }();
    var Be = ["Webkit", "Moz", "ms"], $e = E.createElement("div").style, _e = {};

    function ze(e) {
        var t = S.cssProps[e] || _e[e];
        return t || (e in $e ? e : _e[e] = function (e) {
            var t = e[0].toUpperCase()+e.slice(1), n = Be.length;
            while (n--) if ((e = Be[n]+t) in $e) return e
        }(e) || e)
    }

    var Ue = /^(none|table(?!-c[ea]).+)/, Xe = /^--/,
        Ve = {position: "absolute", visibility: "hidden", display: "block"},
        Ge = {letterSpacing: "0", fontWeight: "400"};

    function Ye(e, t, n) {
        var r = te.exec(t);
        return r ? Math.max(0, r[2]-(n || 0))+(r[3] || "px") : t
    }

    function Qe(e, t, n, r, i, o) {
        var a = "width" === t ? 1 : 0, s = 0, u = 0;
        if (n === (r ? "border" : "content")) return 0;
        for (; a < 4; a += 2) "margin" === n && (u += S.css(e, n+ne[a], !0, i)), r ? ("content" === n && (u -= S.css(e, "padding"+ne[a], !0, i)), "margin" !== n && (u -= S.css(e, "border"+ne[a]+"Width", !0, i))) : (u += S.css(e, "padding"+ne[a], !0, i), "padding" !== n ? u += S.css(e, "border"+ne[a]+"Width", !0, i) : s += S.css(e, "border"+ne[a]+"Width", !0, i));
        return !r && 0 <= o && (u += Math.max(0, Math.ceil(e["offset"+t[0].toUpperCase()+t.slice(1)]-o-u-s-.5)) || 0), u
    }

    function Je(e, t, n) {
        var r = Re(e), i = (!y.boxSizingReliable() || n) && "border-box" === S.css(e, "boxSizing", !1, r), o = i,
            a = We(e, t, r), s = "offset"+t[0].toUpperCase()+t.slice(1);
        if (Pe.test(a)) {
            if (!n) return a;
            a = "auto"
        }
        return (!y.boxSizingReliable() && i || !y.reliableTrDimensions() && A(e, "tr") || "auto" === a || !parseFloat(a) && "inline" === S.css(e, "display", !1, r)) && e.getClientRects().length && (i = "border-box" === S.css(e, "boxSizing", !1, r), (o = s in e) && (a = e[s])), (a = parseFloat(a) || 0)+Qe(e, t, n || (i ? "border" : "content"), o, r, a)+"px"
    }

    function Ke(e, t, n, r, i) {
        return new Ke.prototype.init(e, t, n, r, i)
    }

    S.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) {
                        var n = We(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            gridArea: !0,
            gridColumn: !0,
            gridColumnEnd: !0,
            gridColumnStart: !0,
            gridRow: !0,
            gridRowEnd: !0,
            gridRowStart: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {},
        style: function (e, t, n, r) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var i, o, a, s = X(t), u = Xe.test(t), l = e.style;
                if (u || (t = ze(s)), a = S.cssHooks[t] || S.cssHooks[s], void 0 === n) return a && "get" in a && void 0 !== (i = a.get(e, !1, r)) ? i : l[t];
                "string" === (o = typeof n) && (i = te.exec(n)) && i[1] && (n = se(e, t, i), o = "number"), null != n && n == n && ("number" !== o || u || (n += i && i[3] || (S.cssNumber[s] ? "" : "px")), y.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (l[t] = "inherit"), a && "set" in a && void 0 === (n = a.set(e, n, r)) || (u ? l.setProperty(t, n) : l[t] = n))
            }
        },
        css: function (e, t, n, r) {
            var i, o, a, s = X(t);
            return Xe.test(t) || (t = ze(s)), (a = S.cssHooks[t] || S.cssHooks[s]) && "get" in a && (i = a.get(e, !0, n)), void 0 === i && (i = We(e, t, r)), "normal" === i && t in Ge && (i = Ge[t]), "" === n || n ? (o = parseFloat(i), !0 === n || isFinite(o) ? o || 0 : i) : i
        }
    }), S.each(["height", "width"], function (e, u) {
        S.cssHooks[u] = {
            get: function (e, t, n) {
                if (t) return !Ue.test(S.css(e, "display")) || e.getClientRects().length && e.getBoundingClientRect().width ? Je(e, u, n) : Me(e, Ve, function () {
                    return Je(e, u, n)
                })
            }, set: function (e, t, n) {
                var r, i = Re(e), o = !y.scrollboxSize() && "absolute" === i.position,
                    a = (o || n) && "border-box" === S.css(e, "boxSizing", !1, i), s = n ? Qe(e, u, n, a, i) : 0;
                return a && o && (s -= Math.ceil(e["offset"+u[0].toUpperCase()+u.slice(1)]-parseFloat(i[u])-Qe(e, u, "border", !1, i)-.5)), s && (r = te.exec(t)) && "px" !== (r[3] || "px") && (e.style[u] = t, t = S.css(e, u)), Ye(0, t, s)
            }
        }
    }), S.cssHooks.marginLeft = Fe(y.reliableMarginLeft, function (e, t) {
        if (t) return (parseFloat(We(e, "marginLeft")) || e.getBoundingClientRect().left-Me(e, {marginLeft: 0}, function () {
            return e.getBoundingClientRect().left
        }))+"px"
    }), S.each({margin: "", padding: "", border: "Width"}, function (i, o) {
        S.cssHooks[i+o] = {
            expand: function (e) {
                for (var t = 0, n = {}, r = "string" == typeof e ? e.split(" ") : [e]; t < 4; t++) n[i+ne[t]+o] = r[t] || r[t-2] || r[0];
                return n
            }
        }, "margin" !== i && (S.cssHooks[i+o].set = Ye)
    }), S.fn.extend({
        css: function (e, t) {
            return $(this, function (e, t, n) {
                var r, i, o = {}, a = 0;
                if (Array.isArray(t)) {
                    for (r = Re(e), i = t.length; a < i; a++) o[t[a]] = S.css(e, t[a], !1, r);
                    return o
                }
                return void 0 !== n ? S.style(e, t, n) : S.css(e, t)
            }, e, t, 1 < arguments.length)
        }
    }), ((S.Tween = Ke).prototype = {
        constructor: Ke, init: function (e, t, n, r, i, o) {
            this.elem = e, this.prop = n, this.easing = i || S.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = r, this.unit = o || (S.cssNumber[n] ? "" : "px")
        }, cur: function () {
            var e = Ke.propHooks[this.prop];
            return e && e.get ? e.get(this) : Ke.propHooks._default.get(this)
        }, run: function (e) {
            var t, n = Ke.propHooks[this.prop];
            return this.options.duration ? this.pos = t = S.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end-this.start) * t+this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : Ke.propHooks._default.set(this), this
        }
    }).init.prototype = Ke.prototype, (Ke.propHooks = {
        _default: {
            get: function (e) {
                var t;
                return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = S.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0
            }, set: function (e) {
                S.fx.step[e.prop] ? S.fx.step[e.prop](e) : 1 !== e.elem.nodeType || !S.cssHooks[e.prop] && null == e.elem.style[ze(e.prop)] ? e.elem[e.prop] = e.now : S.style(e.elem, e.prop, e.now+e.unit)
            }
        }
    }).scrollTop = Ke.propHooks.scrollLeft = {
        set: function (e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, S.easing = {
        linear: function (e) {
            return e
        }, swing: function (e) {
            return .5-Math.cos(e * Math.PI) / 2
        }, _default: "swing"
    }, S.fx = Ke.prototype.init, S.fx.step = {};
    var Ze, et, tt, nt, rt = /^(?:toggle|show|hide)$/, it = /queueHooks$/;

    function ot() {
        et && (!1 === E.hidden && C.requestAnimationFrame ? C.requestAnimationFrame(ot) : C.setTimeout(ot, S.fx.interval), S.fx.tick())
    }

    function at() {
        return C.setTimeout(function () {
            Ze = void 0
        }), Ze = Date.now()
    }

    function st(e, t) {
        var n, r = 0, i = {height: e};
        for (t = t ? 1 : 0; r < 4; r += 2-t) i["margin"+(n = ne[r])] = i["padding"+n] = e;
        return t && (i.opacity = i.width = e), i
    }

    function ut(e, t, n) {
        for (var r, i = (lt.tweeners[t] || []).concat(lt.tweeners["*"]), o = 0, a = i.length; o < a; o++) if (r = i[o].call(n, t, e)) return r
    }

    function lt(o, e, t) {
        var n, a, r = 0, i = lt.prefilters.length, s = S.Deferred().always(function () {
            delete u.elem
        }), u = function () {
            if (a) return !1;
            for (var e = Ze || at(), t = Math.max(0, l.startTime+l.duration-e), n = 1-(t / l.duration || 0), r = 0, i = l.tweens.length; r < i; r++) l.tweens[r].run(n);
            return s.notifyWith(o, [l, n, t]), n < 1 && i ? t : (i || s.notifyWith(o, [l, 1, 0]), s.resolveWith(o, [l]), !1)
        }, l = s.promise({
            elem: o,
            props: S.extend({}, e),
            opts: S.extend(!0, {specialEasing: {}, easing: S.easing._default}, t),
            originalProperties: e,
            originalOptions: t,
            startTime: Ze || at(),
            duration: t.duration,
            tweens: [],
            createTween: function (e, t) {
                var n = S.Tween(o, l.opts, e, t, l.opts.specialEasing[e] || l.opts.easing);
                return l.tweens.push(n), n
            },
            stop: function (e) {
                var t = 0, n = e ? l.tweens.length : 0;
                if (a) return this;
                for (a = !0; t < n; t++) l.tweens[t].run(1);
                return e ? (s.notifyWith(o, [l, 1, 0]), s.resolveWith(o, [l, e])) : s.rejectWith(o, [l, e]), this
            }
        }), c = l.props;
        for (!function (e, t) {
            var n, r, i, o, a;
            for (n in e) if (i = t[r = X(n)], o = e[n], Array.isArray(o) && (i = o[1], o = e[n] = o[0]), n !== r && (e[r] = o, delete e[n]), (a = S.cssHooks[r]) && "expand" in a) for (n in o = a.expand(o), delete e[r], o) n in e || (e[n] = o[n], t[n] = i); else t[r] = i
        }(c, l.opts.specialEasing); r < i; r++) if (n = lt.prefilters[r].call(l, o, c, l.opts)) return m(n.stop) && (S._queueHooks(l.elem, l.opts.queue).stop = n.stop.bind(n)), n;
        return S.map(c, ut, l), m(l.opts.start) && l.opts.start.call(o, l), l.progress(l.opts.progress).done(l.opts.done, l.opts.complete).fail(l.opts.fail).always(l.opts.always), S.fx.timer(S.extend(u, {
            elem: o,
            anim: l,
            queue: l.opts.queue
        })), l
    }

    S.Animation = S.extend(lt, {
        tweeners: {
            "*": [function (e, t) {
                var n = this.createTween(e, t);
                return se(n.elem, e, te.exec(t), n), n
            }]
        }, tweener: function (e, t) {
            m(e) ? (t = e, e = ["*"]) : e = e.match(P);
            for (var n, r = 0, i = e.length; r < i; r++) n = e[r], lt.tweeners[n] = lt.tweeners[n] || [], lt.tweeners[n].unshift(t)
        }, prefilters: [function (e, t, n) {
            var r, i, o, a, s, u, l, c, f = "width" in t || "height" in t, p = this, d = {}, h = e.style,
                g = e.nodeType && ae(e), v = Y.get(e, "fxshow");
            for (r in n.queue || (null == (a = S._queueHooks(e, "fx")).unqueued && (a.unqueued = 0, s = a.empty.fire, a.empty.fire = function () {
                a.unqueued || s()
            }), a.unqueued++, p.always(function () {
                p.always(function () {
                    a.unqueued--, S.queue(e, "fx").length || a.empty.fire()
                })
            })), t) if (i = t[r], rt.test(i)) {
                if (delete t[r], o = o || "toggle" === i, i === (g ? "hide" : "show")) {
                    if ("show" !== i || !v || void 0 === v[r]) continue;
                    g = !0
                }
                d[r] = v && v[r] || S.style(e, r)
            }
            if ((u = !S.isEmptyObject(t)) || !S.isEmptyObject(d)) for (r in f && 1 === e.nodeType && (n.overflow = [h.overflow, h.overflowX, h.overflowY], null == (l = v && v.display) && (l = Y.get(e, "display")), "none" === (c = S.css(e, "display")) && (l ? c = l : (le([e], !0), l = e.style.display || l, c = S.css(e, "display"), le([e]))), ("inline" === c || "inline-block" === c && null != l) && "none" === S.css(e, "float") && (u || (p.done(function () {
                h.display = l
            }), null == l && (c = h.display, l = "none" === c ? "" : c)), h.display = "inline-block")), n.overflow && (h.overflow = "hidden", p.always(function () {
                h.overflow = n.overflow[0], h.overflowX = n.overflow[1], h.overflowY = n.overflow[2]
            })), u = !1, d) u || (v ? "hidden" in v && (g = v.hidden) : v = Y.access(e, "fxshow", {display: l}), o && (v.hidden = !g), g && le([e], !0), p.done(function () {
                for (r in g || le([e]), Y.remove(e, "fxshow"), d) S.style(e, r, d[r])
            })), u = ut(g ? v[r] : 0, r, p), r in v || (v[r] = u.start, g && (u.end = u.start, u.start = 0))
        }], prefilter: function (e, t) {
            t ? lt.prefilters.unshift(e) : lt.prefilters.push(e)
        }
    }), S.speed = function (e, t, n) {
        var r = e && "object" == typeof e ? S.extend({}, e) : {
            complete: n || !n && t || m(e) && e,
            duration: e,
            easing: n && t || t && !m(t) && t
        };
        return S.fx.off ? r.duration = 0 : "number" != typeof r.duration && (r.duration in S.fx.speeds ? r.duration = S.fx.speeds[r.duration] : r.duration = S.fx.speeds._default), null != r.queue && !0 !== r.queue || (r.queue = "fx"), r.old = r.complete, r.complete = function () {
            m(r.old) && r.old.call(this), r.queue && S.dequeue(this, r.queue)
        }, r
    }, S.fn.extend({
        fadeTo: function (e, t, n, r) {
            return this.filter(ae).css("opacity", 0).show().end().animate({opacity: t}, e, n, r)
        }, animate: function (t, e, n, r) {
            var i = S.isEmptyObject(t), o = S.speed(e, n, r), a = function () {
                var e = lt(this, S.extend({}, t), o);
                (i || Y.get(this, "finish")) && e.stop(!0)
            };
            return a.finish = a, i || !1 === o.queue ? this.each(a) : this.queue(o.queue, a)
        }, stop: function (i, e, o) {
            var a = function (e) {
                var t = e.stop;
                delete e.stop, t(o)
            };
            return "string" != typeof i && (o = e, e = i, i = void 0), e && this.queue(i || "fx", []), this.each(function () {
                var e = !0, t = null != i && i+"queueHooks", n = S.timers, r = Y.get(this);
                if (t) r[t] && r[t].stop && a(r[t]); else for (t in r) r[t] && r[t].stop && it.test(t) && a(r[t]);
                for (t = n.length; t--;) n[t].elem !== this || null != i && n[t].queue !== i || (n[t].anim.stop(o), e = !1, n.splice(t, 1));
                !e && o || S.dequeue(this, i)
            })
        }, finish: function (a) {
            return !1 !== a && (a = a || "fx"), this.each(function () {
                var e, t = Y.get(this), n = t[a+"queue"], r = t[a+"queueHooks"], i = S.timers, o = n ? n.length : 0;
                for (t.finish = !0, S.queue(this, a, []), r && r.stop && r.stop.call(this, !0), e = i.length; e--;) i[e].elem === this && i[e].queue === a && (i[e].anim.stop(!0), i.splice(e, 1));
                for (e = 0; e < o; e++) n[e] && n[e].finish && n[e].finish.call(this);
                delete t.finish
            })
        }
    }), S.each(["toggle", "show", "hide"], function (e, r) {
        var i = S.fn[r];
        S.fn[r] = function (e, t, n) {
            return null == e || "boolean" == typeof e ? i.apply(this, arguments) : this.animate(st(r, !0), e, t, n)
        }
    }), S.each({
        slideDown: st("show"),
        slideUp: st("hide"),
        slideToggle: st("toggle"),
        fadeIn: {opacity: "show"},
        fadeOut: {opacity: "hide"},
        fadeToggle: {opacity: "toggle"}
    }, function (e, r) {
        S.fn[e] = function (e, t, n) {
            return this.animate(r, e, t, n)
        }
    }), S.timers = [], S.fx.tick = function () {
        var e, t = 0, n = S.timers;
        for (Ze = Date.now(); t < n.length; t++) (e = n[t])() || n[t] !== e || n.splice(t--, 1);
        n.length || S.fx.stop(), Ze = void 0
    }, S.fx.timer = function (e) {
        S.timers.push(e), S.fx.start()
    }, S.fx.interval = 13, S.fx.start = function () {
        et || (et = !0, ot())
    }, S.fx.stop = function () {
        et = null
    }, S.fx.speeds = {slow: 600, fast: 200, _default: 400}, S.fn.delay = function (r, e) {
        return r = S.fx && S.fx.speeds[r] || r, e = e || "fx", this.queue(e, function (e, t) {
            var n = C.setTimeout(e, r);
            t.stop = function () {
                C.clearTimeout(n)
            }
        })
    }, tt = E.createElement("input"), nt = E.createElement("select").appendChild(E.createElement("option")), tt.type = "checkbox", y.checkOn = "" !== tt.value, y.optSelected = nt.selected, (tt = E.createElement("input")).value = "t", tt.type = "radio", y.radioValue = "t" === tt.value;
    var ct, ft = S.expr.attrHandle;
    S.fn.extend({
        attr: function (e, t) {
            return $(this, S.attr, e, t, 1 < arguments.length)
        }, removeAttr: function (e) {
            return this.each(function () {
                S.removeAttr(this, e)
            })
        }
    }), S.extend({
        attr: function (e, t, n) {
            var r, i, o = e.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return "undefined" == typeof e.getAttribute ? S.prop(e, t, n) : (1 === o && S.isXMLDoc(e) || (i = S.attrHooks[t.toLowerCase()] || (S.expr.match.bool.test(t) ? ct : void 0)), void 0 !== n ? null === n ? void S.removeAttr(e, t) : i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : (e.setAttribute(t, n+""), n) : i && "get" in i && null !== (r = i.get(e, t)) ? r : null == (r = S.find.attr(e, t)) ? void 0 : r)
        }, attrHooks: {
            type: {
                set: function (e, t) {
                    if (!y.radioValue && "radio" === t && A(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        }, removeAttr: function (e, t) {
            var n, r = 0, i = t && t.match(P);
            if (i && 1 === e.nodeType) while (n = i[r++]) e.removeAttribute(n)
        }
    }), ct = {
        set: function (e, t, n) {
            return !1 === t ? S.removeAttr(e, n) : e.setAttribute(n, n), n
        }
    }, S.each(S.expr.match.bool.source.match(/\w+/g), function (e, t) {
        var a = ft[t] || S.find.attr;
        ft[t] = function (e, t, n) {
            var r, i, o = t.toLowerCase();
            return n || (i = ft[o], ft[o] = r, r = null != a(e, t, n) ? o : null, ft[o] = i), r
        }
    });
    var pt = /^(?:input|select|textarea|button)$/i, dt = /^(?:a|area)$/i;

    function ht(e) {
        return (e.match(P) || []).join(" ")
    }

    function gt(e) {
        return e.getAttribute && e.getAttribute("class") || ""
    }

    function vt(e) {
        return Array.isArray(e) ? e : "string" == typeof e && e.match(P) || []
    }

    S.fn.extend({
        prop: function (e, t) {
            return $(this, S.prop, e, t, 1 < arguments.length)
        }, removeProp: function (e) {
            return this.each(function () {
                delete this[S.propFix[e] || e]
            })
        }
    }), S.extend({
        prop: function (e, t, n) {
            var r, i, o = e.nodeType;
            if (3 !== o && 8 !== o && 2 !== o) return 1 === o && S.isXMLDoc(e) || (t = S.propFix[t] || t, i = S.propHooks[t]), void 0 !== n ? i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : e[t] = n : i && "get" in i && null !== (r = i.get(e, t)) ? r : e[t]
        }, propHooks: {
            tabIndex: {
                get: function (e) {
                    var t = S.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : pt.test(e.nodeName) || dt.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        }, propFix: {"for": "htmlFor", "class": "className"}
    }), y.optSelected || (S.propHooks.selected = {
        get: function (e) {
            var t = e.parentNode;
            return t && t.parentNode && t.parentNode.selectedIndex, null
        }, set: function (e) {
            var t = e.parentNode;
            t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex)
        }
    }), S.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
        S.propFix[this.toLowerCase()] = this
    }), S.fn.extend({
        addClass: function (t) {
            var e, n, r, i, o, a, s, u = 0;
            if (m(t)) return this.each(function (e) {
                S(this).addClass(t.call(this, e, gt(this)))
            });
            if ((e = vt(t)).length) while (n = this[u++]) if (i = gt(n), r = 1 === n.nodeType && " "+ht(i)+" ") {
                a = 0;
                while (o = e[a++]) r.indexOf(" "+o+" ") < 0 && (r += o+" ");
                i !== (s = ht(r)) && n.setAttribute("class", s)
            }
            return this
        }, removeClass: function (t) {
            var e, n, r, i, o, a, s, u = 0;
            if (m(t)) return this.each(function (e) {
                S(this).removeClass(t.call(this, e, gt(this)))
            });
            if (!arguments.length) return this.attr("class", "");
            if ((e = vt(t)).length) while (n = this[u++]) if (i = gt(n), r = 1 === n.nodeType && " "+ht(i)+" ") {
                a = 0;
                while (o = e[a++]) while (-1 < r.indexOf(" "+o+" ")) r = r.replace(" "+o+" ", " ");
                i !== (s = ht(r)) && n.setAttribute("class", s)
            }
            return this
        }, toggleClass: function (i, t) {
            var o = typeof i, a = "string" === o || Array.isArray(i);
            return "boolean" == typeof t && a ? t ? this.addClass(i) : this.removeClass(i) : m(i) ? this.each(function (e) {
                S(this).toggleClass(i.call(this, e, gt(this), t), t)
            }) : this.each(function () {
                var e, t, n, r;
                if (a) {
                    t = 0, n = S(this), r = vt(i);
                    while (e = r[t++]) n.hasClass(e) ? n.removeClass(e) : n.addClass(e)
                } else void 0 !== i && "boolean" !== o || ((e = gt(this)) && Y.set(this, "__className__", e), this.setAttribute && this.setAttribute("class", e || !1 === i ? "" : Y.get(this, "__className__") || ""))
            })
        }, hasClass: function (e) {
            var t, n, r = 0;
            t = " "+e+" ";
            while (n = this[r++]) if (1 === n.nodeType && -1 < (" "+ht(gt(n))+" ").indexOf(t)) return !0;
            return !1
        }
    });
    var yt = /\r/g;
    S.fn.extend({
        val: function (n) {
            var r, e, i, t = this[0];
            return arguments.length ? (i = m(n), this.each(function (e) {
                var t;
                1 === this.nodeType && (null == (t = i ? n.call(this, e, S(this).val()) : n) ? t = "" : "number" == typeof t ? t += "" : Array.isArray(t) && (t = S.map(t, function (e) {
                    return null == e ? "" : e+""
                })), (r = S.valHooks[this.type] || S.valHooks[this.nodeName.toLowerCase()]) && "set" in r && void 0 !== r.set(this, t, "value") || (this.value = t))
            })) : t ? (r = S.valHooks[t.type] || S.valHooks[t.nodeName.toLowerCase()]) && "get" in r && void 0 !== (e = r.get(t, "value")) ? e : "string" == typeof (e = t.value) ? e.replace(yt, "") : null == e ? "" : e : void 0
        }
    }), S.extend({
        valHooks: {
            option: {
                get: function (e) {
                    var t = S.find.attr(e, "value");
                    return null != t ? t : ht(S.text(e))
                }
            }, select: {
                get: function (e) {
                    var t, n, r, i = e.options, o = e.selectedIndex, a = "select-one" === e.type, s = a ? null : [],
                        u = a ? o+1 : i.length;
                    for (r = o < 0 ? u : a ? o : 0; r < u; r++) if (((n = i[r]).selected || r === o) && !n.disabled && (!n.parentNode.disabled || !A(n.parentNode, "optgroup"))) {
                        if (t = S(n).val(), a) return t;
                        s.push(t)
                    }
                    return s
                }, set: function (e, t) {
                    var n, r, i = e.options, o = S.makeArray(t), a = i.length;
                    while (a--) ((r = i[a]).selected = -1 < S.inArray(S.valHooks.option.get(r), o)) && (n = !0);
                    return n || (e.selectedIndex = -1), o
                }
            }
        }
    }), S.each(["radio", "checkbox"], function () {
        S.valHooks[this] = {
            set: function (e, t) {
                if (Array.isArray(t)) return e.checked = -1 < S.inArray(S(e).val(), t)
            }
        }, y.checkOn || (S.valHooks[this].get = function (e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    }), y.focusin = "onfocusin" in C;
    var mt = /^(?:focusinfocus|focusoutblur)$/, xt = function (e) {
        e.stopPropagation()
    };
    S.extend(S.event, {
        trigger: function (e, t, n, r) {
            var i, o, a, s, u, l, c, f, p = [n || E], d = v.call(e, "type") ? e.type : e,
                h = v.call(e, "namespace") ? e.namespace.split(".") : [];
            if (o = f = a = n = n || E, 3 !== n.nodeType && 8 !== n.nodeType && !mt.test(d+S.event.triggered) && (-1 < d.indexOf(".") && (d = (h = d.split(".")).shift(), h.sort()), u = d.indexOf(":") < 0 && "on"+d, (e = e[S.expando] ? e : new S.Event(d, "object" == typeof e && e)).isTrigger = r ? 2 : 3, e.namespace = h.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)"+h.join("\\.(?:.*\\.|)")+"(\\.|$)") : null, e.result = void 0, e.target || (e.target = n), t = null == t ? [e] : S.makeArray(t, [e]), c = S.event.special[d] || {}, r || !c.trigger || !1 !== c.trigger.apply(n, t))) {
                if (!r && !c.noBubble && !x(n)) {
                    for (s = c.delegateType || d, mt.test(s+d) || (o = o.parentNode); o; o = o.parentNode) p.push(o), a = o;
                    a === (n.ownerDocument || E) && p.push(a.defaultView || a.parentWindow || C)
                }
                i = 0;
                while ((o = p[i++]) && !e.isPropagationStopped()) f = o, e.type = 1 < i ? s : c.bindType || d, (l = (Y.get(o, "events") || Object.create(null))[e.type] && Y.get(o, "handle")) && l.apply(o, t), (l = u && o[u]) && l.apply && V(o) && (e.result = l.apply(o, t), !1 === e.result && e.preventDefault());
                return e.type = d, r || e.isDefaultPrevented() || c._default && !1 !== c._default.apply(p.pop(), t) || !V(n) || u && m(n[d]) && !x(n) && ((a = n[u]) && (n[u] = null), S.event.triggered = d, e.isPropagationStopped() && f.addEventListener(d, xt), n[d](), e.isPropagationStopped() && f.removeEventListener(d, xt), S.event.triggered = void 0, a && (n[u] = a)), e.result
            }
        }, simulate: function (e, t, n) {
            var r = S.extend(new S.Event, n, {type: e, isSimulated: !0});
            S.event.trigger(r, null, t)
        }
    }), S.fn.extend({
        trigger: function (e, t) {
            return this.each(function () {
                S.event.trigger(e, t, this)
            })
        }, triggerHandler: function (e, t) {
            var n = this[0];
            if (n) return S.event.trigger(e, t, n, !0)
        }
    }), y.focusin || S.each({focus: "focusin", blur: "focusout"}, function (n, r) {
        var i = function (e) {
            S.event.simulate(r, e.target, S.event.fix(e))
        };
        S.event.special[r] = {
            setup: function () {
                var e = this.ownerDocument || this.document || this, t = Y.access(e, r);
                t || e.addEventListener(n, i, !0), Y.access(e, r, (t || 0)+1)
            }, teardown: function () {
                var e = this.ownerDocument || this.document || this, t = Y.access(e, r)-1;
                t ? Y.access(e, r, t) : (e.removeEventListener(n, i, !0), Y.remove(e, r))
            }
        }
    });
    var bt = C.location, wt = {guid: Date.now()}, Tt = /\?/;
    S.parseXML = function (e) {
        var t, n;
        if (!e || "string" != typeof e) return null;
        try {
            t = (new C.DOMParser).parseFromString(e, "text/xml")
        } catch (e) {
        }
        return n = t && t.getElementsByTagName("parsererror")[0], t && !n || S.error("Invalid XML: "+(n ? S.map(n.childNodes, function (e) {
            return e.textContent
        }).join("\n") : e)), t
    };
    var Ct = /\[\]$/, Et = /\r?\n/g, St = /^(?:submit|button|image|reset|file)$/i,
        kt = /^(?:input|select|textarea|keygen)/i;

    function At(n, e, r, i) {
        var t;
        if (Array.isArray(e)) S.each(e, function (e, t) {
            r || Ct.test(n) ? i(n, t) : At(n+"["+("object" == typeof t && null != t ? e : "")+"]", t, r, i)
        }); else if (r || "object" !== w(e)) i(n, e); else for (t in e) At(n+"["+t+"]", e[t], r, i)
    }

    S.param = function (e, t) {
        var n, r = [], i = function (e, t) {
            var n = m(t) ? t() : t;
            r[r.length] = encodeURIComponent(e)+"="+encodeURIComponent(null == n ? "" : n)
        };
        if (null == e) return "";
        if (Array.isArray(e) || e.jquery && !S.isPlainObject(e)) S.each(e, function () {
            i(this.name, this.value)
        }); else for (n in e) At(n, e[n], t, i);
        return r.join("&")
    }, S.fn.extend({
        serialize: function () {
            return S.param(this.serializeArray())
        }, serializeArray: function () {
            return this.map(function () {
                var e = S.prop(this, "elements");
                return e ? S.makeArray(e) : this
            }).filter(function () {
                var e = this.type;
                return this.name && !S(this).is(":disabled") && kt.test(this.nodeName) && !St.test(e) && (this.checked || !pe.test(e))
            }).map(function (e, t) {
                var n = S(this).val();
                return null == n ? null : Array.isArray(n) ? S.map(n, function (e) {
                    return {name: t.name, value: e.replace(Et, "\r\n")}
                }) : {name: t.name, value: n.replace(Et, "\r\n")}
            }).get()
        }
    });
    var Nt = /%20/g, jt = /#.*$/, Dt = /([?&])_=[^&]*/, qt = /^(.*?):[ \t]*([^\r\n]*)$/gm, Lt = /^(?:GET|HEAD)$/,
        Ht = /^\/\//, Ot = {}, Pt = {}, Rt = "*/".concat("*"), Mt = E.createElement("a");

    function It(o) {
        return function (e, t) {
            "string" != typeof e && (t = e, e = "*");
            var n, r = 0, i = e.toLowerCase().match(P) || [];
            if (m(t)) while (n = i[r++]) "+" === n[0] ? (n = n.slice(1) || "*", (o[n] = o[n] || []).unshift(t)) : (o[n] = o[n] || []).push(t)
        }
    }

    function Wt(t, i, o, a) {
        var s = {}, u = t === Pt;

        function l(e) {
            var r;
            return s[e] = !0, S.each(t[e] || [], function (e, t) {
                var n = t(i, o, a);
                return "string" != typeof n || u || s[n] ? u ? !(r = n) : void 0 : (i.dataTypes.unshift(n), l(n), !1)
            }), r
        }

        return l(i.dataTypes[0]) || !s["*"] && l("*")
    }

    function Ft(e, t) {
        var n, r, i = S.ajaxSettings.flatOptions || {};
        for (n in t) void 0 !== t[n] && ((i[n] ? e : r || (r = {}))[n] = t[n]);
        return r && S.extend(!0, e, r), e
    }

    Mt.href = bt.href, S.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: bt.href,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(bt.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": Rt,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {xml: /\bxml\b/, html: /\bhtml/, json: /\bjson\b/},
            responseFields: {xml: "responseXML", text: "responseText", json: "responseJSON"},
            converters: {"* text": String, "text html": !0, "text json": JSON.parse, "text xml": S.parseXML},
            flatOptions: {url: !0, context: !0}
        },
        ajaxSetup: function (e, t) {
            return t ? Ft(Ft(e, S.ajaxSettings), t) : Ft(S.ajaxSettings, e)
        },
        ajaxPrefilter: It(Ot),
        ajaxTransport: It(Pt),
        ajax: function (e, t) {
            "object" == typeof e && (t = e, e = void 0), t = t || {};
            var c, f, p, n, d, r, h, g, i, o, v = S.ajaxSetup({}, t), y = v.context || v,
                m = v.context && (y.nodeType || y.jquery) ? S(y) : S.event, x = S.Deferred(),
                b = S.Callbacks("once memory"), w = v.statusCode || {}, a = {}, s = {}, u = "canceled", T = {
                    readyState: 0, getResponseHeader: function (e) {
                        var t;
                        if (h) {
                            if (!n) {
                                n = {};
                                while (t = qt.exec(p)) n[t[1].toLowerCase()+" "] = (n[t[1].toLowerCase()+" "] || []).concat(t[2])
                            }
                            t = n[e.toLowerCase()+" "]
                        }
                        return null == t ? null : t.join(", ")
                    }, getAllResponseHeaders: function () {
                        return h ? p : null
                    }, setRequestHeader: function (e, t) {
                        return null == h && (e = s[e.toLowerCase()] = s[e.toLowerCase()] || e, a[e] = t), this
                    }, overrideMimeType: function (e) {
                        return null == h && (v.mimeType = e), this
                    }, statusCode: function (e) {
                        var t;
                        if (e) if (h) T.always(e[T.status]); else for (t in e) w[t] = [w[t], e[t]];
                        return this
                    }, abort: function (e) {
                        var t = e || u;
                        return c && c.abort(t), l(0, t), this
                    }
                };
            if (x.promise(T), v.url = ((e || v.url || bt.href)+"").replace(Ht, bt.protocol+"//"), v.type = t.method || t.type || v.method || v.type, v.dataTypes = (v.dataType || "*").toLowerCase().match(P) || [""], null == v.crossDomain) {
                r = E.createElement("a");
                try {
                    r.href = v.url, r.href = r.href, v.crossDomain = Mt.protocol+"//"+Mt.host != r.protocol+"//"+r.host
                } catch (e) {
                    v.crossDomain = !0
                }
            }
            if (v.data && v.processData && "string" != typeof v.data && (v.data = S.param(v.data, v.traditional)), Wt(Ot, v, t, T), h) return T;
            for (i in (g = S.event && v.global) && 0 == S.active++ && S.event.trigger("ajaxStart"), v.type = v.type.toUpperCase(), v.hasContent = !Lt.test(v.type), f = v.url.replace(jt, ""), v.hasContent ? v.data && v.processData && 0 === (v.contentType || "").indexOf("application/x-www-form-urlencoded") && (v.data = v.data.replace(Nt, "+")) : (o = v.url.slice(f.length), v.data && (v.processData || "string" == typeof v.data) && (f += (Tt.test(f) ? "&" : "?")+v.data, delete v.data), !1 === v.cache && (f = f.replace(Dt, "$1"), o = (Tt.test(f) ? "&" : "?")+"_="+wt.guid+++o), v.url = f+o), v.ifModified && (S.lastModified[f] && T.setRequestHeader("If-Modified-Since", S.lastModified[f]), S.etag[f] && T.setRequestHeader("If-None-Match", S.etag[f])), (v.data && v.hasContent && !1 !== v.contentType || t.contentType) && T.setRequestHeader("Content-Type", v.contentType), T.setRequestHeader("Accept", v.dataTypes[0] && v.accepts[v.dataTypes[0]] ? v.accepts[v.dataTypes[0]]+("*" !== v.dataTypes[0] ? ", "+Rt+"; q=0.01" : "") : v.accepts["*"]), v.headers) T.setRequestHeader(i, v.headers[i]);
            if (v.beforeSend && (!1 === v.beforeSend.call(y, T, v) || h)) return T.abort();
            if (u = "abort", b.add(v.complete), T.done(v.success), T.fail(v.error), c = Wt(Pt, v, t, T)) {
                if (T.readyState = 1, g && m.trigger("ajaxSend", [T, v]), h) return T;
                v.async && 0 < v.timeout && (d = C.setTimeout(function () {
                    T.abort("timeout")
                }, v.timeout));
                try {
                    h = !1, c.send(a, l)
                } catch (e) {
                    if (h) throw e;
                    l(-1, e)
                }
            } else l(-1, "No Transport");

            function l(e, t, n, r) {
                var i, o, a, s, u, l = t;
                h || (h = !0, d && C.clearTimeout(d), c = void 0, p = r || "", T.readyState = 0 < e ? 4 : 0, i = 200 <= e && e < 300 || 304 === e, n && (s = function (e, t, n) {
                    var r, i, o, a, s = e.contents, u = e.dataTypes;
                    while ("*" === u[0]) u.shift(), void 0 === r && (r = e.mimeType || t.getResponseHeader("Content-Type"));
                    if (r) for (i in s) if (s[i] && s[i].test(r)) {
                        u.unshift(i);
                        break
                    }
                    if (u[0] in n) o = u[0]; else {
                        for (i in n) {
                            if (!u[0] || e.converters[i+" "+u[0]]) {
                                o = i;
                                break
                            }
                            a || (a = i)
                        }
                        o = o || a
                    }
                    if (o) return o !== u[0] && u.unshift(o), n[o]
                }(v, T, n)), !i && -1 < S.inArray("script", v.dataTypes) && S.inArray("json", v.dataTypes) < 0 && (v.converters["text script"] = function () {
                }), s = function (e, t, n, r) {
                    var i, o, a, s, u, l = {}, c = e.dataTypes.slice();
                    if (c[1]) for (a in e.converters) l[a.toLowerCase()] = e.converters[a];
                    o = c.shift();
                    while (o) if (e.responseFields[o] && (n[e.responseFields[o]] = t), !u && r && e.dataFilter && (t = e.dataFilter(t, e.dataType)), u = o, o = c.shift()) if ("*" === o) o = u; else if ("*" !== u && u !== o) {
                        if (!(a = l[u+" "+o] || l["* "+o])) for (i in l) if ((s = i.split(" "))[1] === o && (a = l[u+" "+s[0]] || l["* "+s[0]])) {
                            !0 === a ? a = l[i] : !0 !== l[i] && (o = s[0], c.unshift(s[1]));
                            break
                        }
                        if (!0 !== a) if (a && e["throws"]) t = a(t); else try {
                            t = a(t)
                        } catch (e) {
                            return {state: "parsererror", error: a ? e : "No conversion from "+u+" to "+o}
                        }
                    }
                    return {state: "success", data: t}
                }(v, s, T, i), i ? (v.ifModified && ((u = T.getResponseHeader("Last-Modified")) && (S.lastModified[f] = u), (u = T.getResponseHeader("etag")) && (S.etag[f] = u)), 204 === e || "HEAD" === v.type ? l = "nocontent" : 304 === e ? l = "notmodified" : (l = s.state, o = s.data, i = !(a = s.error))) : (a = l, !e && l || (l = "error", e < 0 && (e = 0))), T.status = e, T.statusText = (t || l)+"", i ? x.resolveWith(y, [o, l, T]) : x.rejectWith(y, [T, l, a]), T.statusCode(w), w = void 0, g && m.trigger(i ? "ajaxSuccess" : "ajaxError", [T, v, i ? o : a]), b.fireWith(y, [T, l]), g && (m.trigger("ajaxComplete", [T, v]), --S.active || S.event.trigger("ajaxStop")))
            }

            return T
        },
        getJSON: function (e, t, n) {
            return S.get(e, t, n, "json")
        },
        getScript: function (e, t) {
            return S.get(e, void 0, t, "script")
        }
    }), S.each(["get", "post"], function (e, i) {
        S[i] = function (e, t, n, r) {
            return m(t) && (r = r || n, n = t, t = void 0), S.ajax(S.extend({
                url: e,
                type: i,
                dataType: r,
                data: t,
                success: n
            }, S.isPlainObject(e) && e))
        }
    }), S.ajaxPrefilter(function (e) {
        var t;
        for (t in e.headers) "content-type" === t.toLowerCase() && (e.contentType = e.headers[t] || "")
    }), S._evalUrl = function (e, t, n) {
        return S.ajax({
            url: e,
            type: "GET",
            dataType: "script",
            cache: !0,
            async: !1,
            global: !1,
            converters: {
                "text script": function () {
                }
            },
            dataFilter: function (e) {
                S.globalEval(e, t, n)
            }
        })
    }, S.fn.extend({
        wrapAll: function (e) {
            var t;
            return this[0] && (m(e) && (e = e.call(this[0])), t = S(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map(function () {
                var e = this;
                while (e.firstElementChild) e = e.firstElementChild;
                return e
            }).append(this)), this
        }, wrapInner: function (n) {
            return m(n) ? this.each(function (e) {
                S(this).wrapInner(n.call(this, e))
            }) : this.each(function () {
                var e = S(this), t = e.contents();
                t.length ? t.wrapAll(n) : e.append(n)
            })
        }, wrap: function (t) {
            var n = m(t);
            return this.each(function (e) {
                S(this).wrapAll(n ? t.call(this, e) : t)
            })
        }, unwrap: function (e) {
            return this.parent(e).not("body").each(function () {
                S(this).replaceWith(this.childNodes)
            }), this
        }
    }), S.expr.pseudos.hidden = function (e) {
        return !S.expr.pseudos.visible(e)
    }, S.expr.pseudos.visible = function (e) {
        return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length)
    }, S.ajaxSettings.xhr = function () {
        try {
            return new C.XMLHttpRequest
        } catch (e) {
        }
    };
    var Bt = {0: 200, 1223: 204}, $t = S.ajaxSettings.xhr();
    y.cors = !!$t && "withCredentials" in $t, y.ajax = $t = !!$t, S.ajaxTransport(function (i) {
        var o, a;
        if (y.cors || $t && !i.crossDomain) return {
            send: function (e, t) {
                var n, r = i.xhr();
                if (r.open(i.type, i.url, i.async, i.username, i.password), i.xhrFields) for (n in i.xhrFields) r[n] = i.xhrFields[n];
                for (n in i.mimeType && r.overrideMimeType && r.overrideMimeType(i.mimeType), i.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest"), e) r.setRequestHeader(n, e[n]);
                o = function (e) {
                    return function () {
                        o && (o = a = r.onload = r.onerror = r.onabort = r.ontimeout = r.onreadystatechange = null, "abort" === e ? r.abort() : "error" === e ? "number" != typeof r.status ? t(0, "error") : t(r.status, r.statusText) : t(Bt[r.status] || r.status, r.statusText, "text" !== (r.responseType || "text") || "string" != typeof r.responseText ? {binary: r.response} : {text: r.responseText}, r.getAllResponseHeaders()))
                    }
                }, r.onload = o(), a = r.onerror = r.ontimeout = o("error"), void 0 !== r.onabort ? r.onabort = a : r.onreadystatechange = function () {
                    4 === r.readyState && C.setTimeout(function () {
                        o && a()
                    })
                }, o = o("abort");
                try {
                    r.send(i.hasContent && i.data || null)
                } catch (e) {
                    if (o) throw e
                }
            }, abort: function () {
                o && o()
            }
        }
    }), S.ajaxPrefilter(function (e) {
        e.crossDomain && (e.contents.script = !1)
    }), S.ajaxSetup({
        accepts: {script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},
        contents: {script: /\b(?:java|ecma)script\b/},
        converters: {
            "text script": function (e) {
                return S.globalEval(e), e
            }
        }
    }), S.ajaxPrefilter("script", function (e) {
        void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
    }), S.ajaxTransport("script", function (n) {
        var r, i;
        if (n.crossDomain || n.scriptAttrs) return {
            send: function (e, t) {
                r = S("<script>").attr(n.scriptAttrs || {}).prop({
                    charset: n.scriptCharset,
                    src: n.url
                }).on("load error", i = function (e) {
                    r.remove(), i = null, e && t("error" === e.type ? 404 : 200, e.type)
                }), E.head.appendChild(r[0])
            }, abort: function () {
                i && i()
            }
        }
    });
    var _t, zt = [], Ut = /(=)\?(?=&|$)|\?\?/;
    S.ajaxSetup({
        jsonp: "callback", jsonpCallback: function () {
            var e = zt.pop() || S.expando+"_"+wt.guid++;
            return this[e] = !0, e
        }
    }), S.ajaxPrefilter("json jsonp", function (e, t, n) {
        var r, i, o,
            a = !1 !== e.jsonp && (Ut.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && Ut.test(e.data) && "data");
        if (a || "jsonp" === e.dataTypes[0]) return r = e.jsonpCallback = m(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, a ? e[a] = e[a].replace(Ut, "$1"+r) : !1 !== e.jsonp && (e.url += (Tt.test(e.url) ? "&" : "?")+e.jsonp+"="+r), e.converters["script json"] = function () {
            return o || S.error(r+" was not called"), o[0]
        }, e.dataTypes[0] = "json", i = C[r], C[r] = function () {
            o = arguments
        }, n.always(function () {
            void 0 === i ? S(C).removeProp(r) : C[r] = i, e[r] && (e.jsonpCallback = t.jsonpCallback, zt.push(r)), o && m(i) && i(o[0]), o = i = void 0
        }), "script"
    }), y.createHTMLDocument = ((_t = E.implementation.createHTMLDocument("").body).innerHTML = "<form></form><form></form>", 2 === _t.childNodes.length), S.parseHTML = function (e, t, n) {
        return "string" != typeof e ? [] : ("boolean" == typeof t && (n = t, t = !1), t || (y.createHTMLDocument ? ((r = (t = E.implementation.createHTMLDocument("")).createElement("base")).href = E.location.href, t.head.appendChild(r)) : t = E), o = !n && [], (i = N.exec(e)) ? [t.createElement(i[1])] : (i = xe([e], t, o), o && o.length && S(o).remove(), S.merge([], i.childNodes)));
        var r, i, o
    }, S.fn.load = function (e, t, n) {
        var r, i, o, a = this, s = e.indexOf(" ");
        return -1 < s && (r = ht(e.slice(s)), e = e.slice(0, s)), m(t) ? (n = t, t = void 0) : t && "object" == typeof t && (i = "POST"), 0 < a.length && S.ajax({
            url: e,
            type: i || "GET",
            dataType: "html",
            data: t
        }).done(function (e) {
            o = arguments, a.html(r ? S("<div>").append(S.parseHTML(e)).find(r) : e)
        }).always(n && function (e, t) {
            a.each(function () {
                n.apply(this, o || [e.responseText, t, e])
            })
        }), this
    }, S.expr.pseudos.animated = function (t) {
        return S.grep(S.timers, function (e) {
            return t === e.elem
        }).length
    }, S.offset = {
        setOffset: function (e, t, n) {
            var r, i, o, a, s, u, l = S.css(e, "position"), c = S(e), f = {};
            "static" === l && (e.style.position = "relative"), s = c.offset(), o = S.css(e, "top"), u = S.css(e, "left"), ("absolute" === l || "fixed" === l) && -1 < (o+u).indexOf("auto") ? (a = (r = c.position()).top, i = r.left) : (a = parseFloat(o) || 0, i = parseFloat(u) || 0), m(t) && (t = t.call(e, n, S.extend({}, s))), null != t.top && (f.top = t.top-s.top+a), null != t.left && (f.left = t.left-s.left+i), "using" in t ? t.using.call(e, f) : c.css(f)
        }
    }, S.fn.extend({
        offset: function (t) {
            if (arguments.length) return void 0 === t ? this : this.each(function (e) {
                S.offset.setOffset(this, t, e)
            });
            var e, n, r = this[0];
            return r ? r.getClientRects().length ? (e = r.getBoundingClientRect(), n = r.ownerDocument.defaultView, {
                top: e.top+n.pageYOffset,
                left: e.left+n.pageXOffset
            }) : {top: 0, left: 0} : void 0
        }, position: function () {
            if (this[0]) {
                var e, t, n, r = this[0], i = {top: 0, left: 0};
                if ("fixed" === S.css(r, "position")) t = r.getBoundingClientRect(); else {
                    t = this.offset(), n = r.ownerDocument, e = r.offsetParent || n.documentElement;
                    while (e && (e === n.body || e === n.documentElement) && "static" === S.css(e, "position")) e = e.parentNode;
                    e && e !== r && 1 === e.nodeType && ((i = S(e).offset()).top += S.css(e, "borderTopWidth", !0), i.left += S.css(e, "borderLeftWidth", !0))
                }
                return {top: t.top-i.top-S.css(r, "marginTop", !0), left: t.left-i.left-S.css(r, "marginLeft", !0)}
            }
        }, offsetParent: function () {
            return this.map(function () {
                var e = this.offsetParent;
                while (e && "static" === S.css(e, "position")) e = e.offsetParent;
                return e || re
            })
        }
    }), S.each({scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, function (t, i) {
        var o = "pageYOffset" === i;
        S.fn[t] = function (e) {
            return $(this, function (e, t, n) {
                var r;
                if (x(e) ? r = e : 9 === e.nodeType && (r = e.defaultView), void 0 === n) return r ? r[i] : e[t];
                r ? r.scrollTo(o ? r.pageXOffset : n, o ? n : r.pageYOffset) : e[t] = n
            }, t, e, arguments.length)
        }
    }), S.each(["top", "left"], function (e, n) {
        S.cssHooks[n] = Fe(y.pixelPosition, function (e, t) {
            if (t) return t = We(e, n), Pe.test(t) ? S(e).position()[n]+"px" : t
        })
    }), S.each({Height: "height", Width: "width"}, function (a, s) {
        S.each({padding: "inner"+a, content: s, "": "outer"+a}, function (r, o) {
            S.fn[o] = function (e, t) {
                var n = arguments.length && (r || "boolean" != typeof e),
                    i = r || (!0 === e || !0 === t ? "margin" : "border");
                return $(this, function (e, t, n) {
                    var r;
                    return x(e) ? 0 === o.indexOf("outer") ? e["inner"+a] : e.document.documentElement["client"+a] : 9 === e.nodeType ? (r = e.documentElement, Math.max(e.body["scroll"+a], r["scroll"+a], e.body["offset"+a], r["offset"+a], r["client"+a])) : void 0 === n ? S.css(e, t, i) : S.style(e, t, n, i)
                }, s, n ? e : void 0, n)
            }
        })
    }), S.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (e, t) {
        S.fn[t] = function (e) {
            return this.on(t, e)
        }
    }), S.fn.extend({
        bind: function (e, t, n) {
            return this.on(e, null, t, n)
        }, unbind: function (e, t) {
            return this.off(e, null, t)
        }, delegate: function (e, t, n, r) {
            return this.on(t, e, n, r)
        }, undelegate: function (e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        }, hover: function (e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        }
    }), S.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function (e, n) {
        S.fn[n] = function (e, t) {
            return 0 < arguments.length ? this.on(n, null, e, t) : this.trigger(n)
        }
    });
    var Xt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    S.proxy = function (e, t) {
        var n, r, i;
        if ("string" == typeof t && (n = e[t], t = e, e = n), m(e)) return r = s.call(arguments, 2), (i = function () {
            return e.apply(t || this, r.concat(s.call(arguments)))
        }).guid = e.guid = e.guid || S.guid++, i
    }, S.holdReady = function (e) {
        e ? S.readyWait++ : S.ready(!0)
    }, S.isArray = Array.isArray, S.parseJSON = JSON.parse, S.nodeName = A, S.isFunction = m, S.isWindow = x, S.camelCase = X, S.type = w, S.now = Date.now, S.isNumeric = function (e) {
        var t = S.type(e);
        return ("number" === t || "string" === t) && !isNaN(e-parseFloat(e))
    }, S.trim = function (e) {
        return null == e ? "" : (e+"").replace(Xt, "")
    }, "function" == typeof define && define.amd && define("jquery", [], function () {
        return S
    });
    var Vt = C.jQuery, Gt = C.$;
    return S.noConflict = function (e) {
        return C.$ === S && (C.$ = Gt), e && C.jQuery === S && (C.jQuery = Vt), S
    }, "undefined" == typeof e && (C.jQuery = C.$ = S), S
});

/**
 * @popperjs/core v2.11.4 - MIT License
 */

!function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? t(exports) : "function" == typeof define && define.amd ? define(["exports"], t) : t((e = "undefined" != typeof globalThis ? globalThis : e || self).Popper = {})
}(this, (function (e) {
    "use strict";

    function t(e) {
        if (null == e) return window;
        if ("[object Window]" !== e.toString()) {
            var t = e.ownerDocument;
            return t && t.defaultView || window
        }
        return e
    }

    function n(e) {
        return e instanceof t(e).Element || e instanceof Element
    }

    function r(e) {
        return e instanceof t(e).HTMLElement || e instanceof HTMLElement
    }

    function o(e) {
        return "undefined" != typeof ShadowRoot && (e instanceof t(e).ShadowRoot || e instanceof ShadowRoot)
    }

    var i = Math.max, a = Math.min, s = Math.round;

    function f(e, t) {
        void 0 === t && (t = !1);
        var n = e.getBoundingClientRect(), o = 1, i = 1;
        if (r(e) && t) {
            var a = e.offsetHeight, f = e.offsetWidth;
            f > 0 && (o = s(n.width) / f || 1), a > 0 && (i = s(n.height) / a || 1)
        }
        return {
            width: n.width / o,
            height: n.height / i,
            top: n.top / i,
            right: n.right / o,
            bottom: n.bottom / i,
            left: n.left / o,
            x: n.left / o,
            y: n.top / i
        }
    }

    function c(e) {
        var n = t(e);
        return {scrollLeft: n.pageXOffset, scrollTop: n.pageYOffset}
    }

    function p(e) {
        return e ? (e.nodeName || "").toLowerCase() : null
    }

    function u(e) {
        return ((n(e) ? e.ownerDocument : e.document) || window.document).documentElement
    }

    function l(e) {
        return f(u(e)).left+c(e).scrollLeft
    }

    function d(e) {
        return t(e).getComputedStyle(e)
    }

    function h(e) {
        var t = d(e), n = t.overflow, r = t.overflowX, o = t.overflowY;
        return /auto|scroll|overlay|hidden/.test(n+o+r)
    }

    function m(e, n, o) {
        void 0 === o && (o = !1);
        var i, a, d = r(n), m = r(n) && function (e) {
            var t = e.getBoundingClientRect(), n = s(t.width) / e.offsetWidth || 1,
                r = s(t.height) / e.offsetHeight || 1;
            return 1 !== n || 1 !== r
        }(n), v = u(n), g = f(e, m), y = {scrollLeft: 0, scrollTop: 0}, b = {x: 0, y: 0};
        return (d || !d && !o) && (("body" !== p(n) || h(v)) && (y = (i = n) !== t(i) && r(i) ? {
            scrollLeft: (a = i).scrollLeft,
            scrollTop: a.scrollTop
        } : c(i)), r(n) ? ((b = f(n, !0)).x += n.clientLeft, b.y += n.clientTop) : v && (b.x = l(v))), {
            x: g.left+y.scrollLeft-b.x,
            y: g.top+y.scrollTop-b.y,
            width: g.width,
            height: g.height
        }
    }

    function v(e) {
        var t = f(e), n = e.offsetWidth, r = e.offsetHeight;
        return Math.abs(t.width-n) <= 1 && (n = t.width), Math.abs(t.height-r) <= 1 && (r = t.height), {
            x: e.offsetLeft,
            y: e.offsetTop,
            width: n,
            height: r
        }
    }

    function g(e) {
        return "html" === p(e) ? e : e.assignedSlot || e.parentNode || (o(e) ? e.host : null) || u(e)
    }

    function y(e) {
        return ["html", "body", "#document"].indexOf(p(e)) >= 0 ? e.ownerDocument.body : r(e) && h(e) ? e : y(g(e))
    }

    function b(e, n) {
        var r;
        void 0 === n && (n = []);
        var o = y(e), i = o === (null == (r = e.ownerDocument) ? void 0 : r.body), a = t(o),
            s = i ? [a].concat(a.visualViewport || [], h(o) ? o : []) : o, f = n.concat(s);
        return i ? f : f.concat(b(g(s)))
    }

    function x(e) {
        return ["table", "td", "th"].indexOf(p(e)) >= 0
    }

    function w(e) {
        return r(e) && "fixed" !== d(e).position ? e.offsetParent : null
    }

    function O(e) {
        for (var n = t(e), i = w(e); i && x(i) && "static" === d(i).position;) i = w(i);
        return i && ("html" === p(i) || "body" === p(i) && "static" === d(i).position) ? n : i || function (e) {
            var t = -1 !== navigator.userAgent.toLowerCase().indexOf("firefox");
            if (-1 !== navigator.userAgent.indexOf("Trident") && r(e) && "fixed" === d(e).position) return null;
            var n = g(e);
            for (o(n) && (n = n.host); r(n) && ["html", "body"].indexOf(p(n)) < 0;) {
                var i = d(n);
                if ("none" !== i.transform || "none" !== i.perspective || "paint" === i.contain || -1 !== ["transform", "perspective"].indexOf(i.willChange) || t && "filter" === i.willChange || t && i.filter && "none" !== i.filter) return n;
                n = n.parentNode
            }
            return null
        }(e) || n
    }

    var j = "top", E = "bottom", D = "right", A = "left", L = "auto", P = [j, E, D, A], M = "start", k = "end",
        W = "viewport", B = "popper", H = P.reduce((function (e, t) {
            return e.concat([t+"-"+M, t+"-"+k])
        }), []), T = [].concat(P, [L]).reduce((function (e, t) {
            return e.concat([t, t+"-"+M, t+"-"+k])
        }), []),
        R = ["beforeRead", "read", "afterRead", "beforeMain", "main", "afterMain", "beforeWrite", "write", "afterWrite"];

    function S(e) {
        var t = new Map, n = new Set, r = [];

        function o(e) {
            n.add(e.name), [].concat(e.requires || [], e.requiresIfExists || []).forEach((function (e) {
                if (!n.has(e)) {
                    var r = t.get(e);
                    r && o(r)
                }
            })), r.push(e)
        }

        return e.forEach((function (e) {
            t.set(e.name, e)
        })), e.forEach((function (e) {
            n.has(e.name) || o(e)
        })), r
    }

    function C(e) {
        return e.split("-")[0]
    }

    function q(e, t) {
        var n = t.getRootNode && t.getRootNode();
        if (e.contains(t)) return !0;
        if (n && o(n)) {
            var r = t;
            do {
                if (r && e.isSameNode(r)) return !0;
                r = r.parentNode || r.host
            } while (r)
        }
        return !1
    }

    function V(e) {
        return Object.assign({}, e, {left: e.x, top: e.y, right: e.x+e.width, bottom: e.y+e.height})
    }

    function N(e, r) {
        return r === W ? V(function (e) {
            var n = t(e), r = u(e), o = n.visualViewport, i = r.clientWidth, a = r.clientHeight, s = 0, f = 0;
            return o && (i = o.width, a = o.height, /^((?!chrome|android).)*safari/i.test(navigator.userAgent) || (s = o.offsetLeft, f = o.offsetTop)), {
                width: i,
                height: a,
                x: s+l(e),
                y: f
            }
        }(e)) : n(r) ? function (e) {
            var t = f(e);
            return t.top = t.top+e.clientTop, t.left = t.left+e.clientLeft, t.bottom = t.top+e.clientHeight, t.right = t.left+e.clientWidth, t.width = e.clientWidth, t.height = e.clientHeight, t.x = t.left, t.y = t.top, t
        }(r) : V(function (e) {
            var t, n = u(e), r = c(e), o = null == (t = e.ownerDocument) ? void 0 : t.body,
                a = i(n.scrollWidth, n.clientWidth, o ? o.scrollWidth : 0, o ? o.clientWidth : 0),
                s = i(n.scrollHeight, n.clientHeight, o ? o.scrollHeight : 0, o ? o.clientHeight : 0),
                f = -r.scrollLeft+l(e), p = -r.scrollTop;
            return "rtl" === d(o || n).direction && (f += i(n.clientWidth, o ? o.clientWidth : 0)-a), {
                width: a,
                height: s,
                x: f,
                y: p
            }
        }(u(e)))
    }

    function I(e, t, o) {
        var s = "clippingParents" === t ? function (e) {
            var t = b(g(e)), o = ["absolute", "fixed"].indexOf(d(e).position) >= 0 && r(e) ? O(e) : e;
            return n(o) ? t.filter((function (e) {
                return n(e) && q(e, o) && "body" !== p(e)
            })) : []
        }(e) : [].concat(t), f = [].concat(s, [o]), c = f[0], u = f.reduce((function (t, n) {
            var r = N(e, n);
            return t.top = i(r.top, t.top), t.right = a(r.right, t.right), t.bottom = a(r.bottom, t.bottom), t.left = i(r.left, t.left), t
        }), N(e, c));
        return u.width = u.right-u.left, u.height = u.bottom-u.top, u.x = u.left, u.y = u.top, u
    }

    function _(e) {
        return e.split("-")[1]
    }

    function F(e) {
        return ["top", "bottom"].indexOf(e) >= 0 ? "x" : "y"
    }

    function U(e) {
        var t, n = e.reference, r = e.element, o = e.placement, i = o ? C(o) : null, a = o ? _(o) : null,
            s = n.x+n.width / 2-r.width / 2, f = n.y+n.height / 2-r.height / 2;
        switch (i) {
            case j:
                t = {x: s, y: n.y-r.height};
                break;
            case E:
                t = {x: s, y: n.y+n.height};
                break;
            case D:
                t = {x: n.x+n.width, y: f};
                break;
            case A:
                t = {x: n.x-r.width, y: f};
                break;
            default:
                t = {x: n.x, y: n.y}
        }
        var c = i ? F(i) : null;
        if (null != c) {
            var p = "y" === c ? "height" : "width";
            switch (a) {
                case M:
                    t[c] = t[c]-(n[p] / 2-r[p] / 2);
                    break;
                case k:
                    t[c] = t[c]+(n[p] / 2-r[p] / 2)
            }
        }
        return t
    }

    function z(e) {
        return Object.assign({}, {top: 0, right: 0, bottom: 0, left: 0}, e)
    }

    function X(e, t) {
        return t.reduce((function (t, n) {
            return t[n] = e, t
        }), {})
    }

    function Y(e, t) {
        void 0 === t && (t = {});
        var r = t, o = r.placement, i = void 0 === o ? e.placement : o, a = r.boundary,
            s = void 0 === a ? "clippingParents" : a, c = r.rootBoundary, p = void 0 === c ? W : c,
            l = r.elementContext, d = void 0 === l ? B : l, h = r.altBoundary, m = void 0 !== h && h, v = r.padding,
            g = void 0 === v ? 0 : v, y = z("number" != typeof g ? g : X(g, P)), b = d === B ? "reference" : B,
            x = e.rects.popper, w = e.elements[m ? b : d],
            O = I(n(w) ? w : w.contextElement || u(e.elements.popper), s, p), A = f(e.elements.reference),
            L = U({reference: A, element: x, strategy: "absolute", placement: i}), M = V(Object.assign({}, x, L)),
            k = d === B ? M : A, H = {
                top: O.top-k.top+y.top,
                bottom: k.bottom-O.bottom+y.bottom,
                left: O.left-k.left+y.left,
                right: k.right-O.right+y.right
            }, T = e.modifiersData.offset;
        if (d === B && T) {
            var R = T[i];
            Object.keys(H).forEach((function (e) {
                var t = [D, E].indexOf(e) >= 0 ? 1 : -1, n = [j, E].indexOf(e) >= 0 ? "y" : "x";
                H[e] += R[n] * t
            }))
        }
        return H
    }

    var G = {placement: "bottom", modifiers: [], strategy: "absolute"};

    function J() {
        for (var e = arguments.length, t = new Array(e), n = 0; n < e; n++) t[n] = arguments[n];
        return !t.some((function (e) {
            return !(e && "function" == typeof e.getBoundingClientRect)
        }))
    }

    function K(e) {
        void 0 === e && (e = {});
        var t = e, r = t.defaultModifiers, o = void 0 === r ? [] : r, i = t.defaultOptions, a = void 0 === i ? G : i;
        return function (e, t, r) {
            void 0 === r && (r = a);
            var i, s, f = {
                placement: "bottom",
                orderedModifiers: [],
                options: Object.assign({}, G, a),
                modifiersData: {},
                elements: {reference: e, popper: t},
                attributes: {},
                styles: {}
            }, c = [], p = !1, u = {
                state: f, setOptions: function (r) {
                    var i = "function" == typeof r ? r(f.options) : r;
                    l(), f.options = Object.assign({}, a, f.options, i), f.scrollParents = {
                        reference: n(e) ? b(e) : e.contextElement ? b(e.contextElement) : [],
                        popper: b(t)
                    };
                    var s, p, d = function (e) {
                        var t = S(e);
                        return R.reduce((function (e, n) {
                            return e.concat(t.filter((function (e) {
                                return e.phase === n
                            })))
                        }), [])
                    }((s = [].concat(o, f.options.modifiers), p = s.reduce((function (e, t) {
                        var n = e[t.name];
                        return e[t.name] = n ? Object.assign({}, n, t, {
                            options: Object.assign({}, n.options, t.options),
                            data: Object.assign({}, n.data, t.data)
                        }) : t, e
                    }), {}), Object.keys(p).map((function (e) {
                        return p[e]
                    }))));
                    return f.orderedModifiers = d.filter((function (e) {
                        return e.enabled
                    })), f.orderedModifiers.forEach((function (e) {
                        var t = e.name, n = e.options, r = void 0 === n ? {} : n, o = e.effect;
                        if ("function" == typeof o) {
                            var i = o({state: f, name: t, instance: u, options: r}), a = function () {
                            };
                            c.push(i || a)
                        }
                    })), u.update()
                }, forceUpdate: function () {
                    if (!p) {
                        var e = f.elements, t = e.reference, n = e.popper;
                        if (J(t, n)) {
                            f.rects = {
                                reference: m(t, O(n), "fixed" === f.options.strategy),
                                popper: v(n)
                            }, f.reset = !1, f.placement = f.options.placement, f.orderedModifiers.forEach((function (e) {
                                return f.modifiersData[e.name] = Object.assign({}, e.data)
                            }));
                            for (var r = 0; r < f.orderedModifiers.length; r++) if (!0 !== f.reset) {
                                var o = f.orderedModifiers[r], i = o.fn, a = o.options, s = void 0 === a ? {} : a,
                                    c = o.name;
                                "function" == typeof i && (f = i({state: f, options: s, name: c, instance: u}) || f)
                            } else f.reset = !1, r = -1
                        }
                    }
                }, update: (i = function () {
                    return new Promise((function (e) {
                        u.forceUpdate(), e(f)
                    }))
                }, function () {
                    return s || (s = new Promise((function (e) {
                        Promise.resolve().then((function () {
                            s = void 0, e(i())
                        }))
                    }))), s
                }), destroy: function () {
                    l(), p = !0
                }
            };
            if (!J(e, t)) return u;

            function l() {
                c.forEach((function (e) {
                    return e()
                })), c = []
            }

            return u.setOptions(r).then((function (e) {
                !p && r.onFirstUpdate && r.onFirstUpdate(e)
            })), u
        }
    }

    var Q = {passive: !0};
    var Z = {
        name: "eventListeners", enabled: !0, phase: "write", fn: function () {
        }, effect: function (e) {
            var n = e.state, r = e.instance, o = e.options, i = o.scroll, a = void 0 === i || i, s = o.resize,
                f = void 0 === s || s, c = t(n.elements.popper),
                p = [].concat(n.scrollParents.reference, n.scrollParents.popper);
            return a && p.forEach((function (e) {
                e.addEventListener("scroll", r.update, Q)
            })), f && c.addEventListener("resize", r.update, Q), function () {
                a && p.forEach((function (e) {
                    e.removeEventListener("scroll", r.update, Q)
                })), f && c.removeEventListener("resize", r.update, Q)
            }
        }, data: {}
    };
    var $ = {
        name: "popperOffsets", enabled: !0, phase: "read", fn: function (e) {
            var t = e.state, n = e.name;
            t.modifiersData[n] = U({
                reference: t.rects.reference,
                element: t.rects.popper,
                strategy: "absolute",
                placement: t.placement
            })
        }, data: {}
    }, ee = {top: "auto", right: "auto", bottom: "auto", left: "auto"};

    function te(e) {
        var n, r = e.popper, o = e.popperRect, i = e.placement, a = e.variation, f = e.offsets, c = e.position,
            p = e.gpuAcceleration, l = e.adaptive, h = e.roundOffsets, m = e.isFixed, v = f.x, g = void 0 === v ? 0 : v,
            y = f.y, b = void 0 === y ? 0 : y, x = "function" == typeof h ? h({x: g, y: b}) : {x: g, y: b};
        g = x.x, b = x.y;
        var w = f.hasOwnProperty("x"), L = f.hasOwnProperty("y"), P = A, M = j, W = window;
        if (l) {
            var B = O(r), H = "clientHeight", T = "clientWidth";
            if (B === t(r) && "static" !== d(B = u(r)).position && "absolute" === c && (H = "scrollHeight", T = "scrollWidth"), B = B, i === j || (i === A || i === D) && a === k) M = E, b -= (m && B === W && W.visualViewport ? W.visualViewport.height : B[H])-o.height, b *= p ? 1 : -1;
            if (i === A || (i === j || i === E) && a === k) P = D, g -= (m && B === W && W.visualViewport ? W.visualViewport.width : B[T])-o.width, g *= p ? 1 : -1
        }
        var R, S = Object.assign({position: c}, l && ee), C = !0 === h ? function (e) {
            var t = e.x, n = e.y, r = window.devicePixelRatio || 1;
            return {x: s(t * r) / r || 0, y: s(n * r) / r || 0}
        }({x: g, y: b}) : {x: g, y: b};
        return g = C.x, b = C.y, p ? Object.assign({}, S, ((R = {})[M] = L ? "0" : "", R[P] = w ? "0" : "", R.transform = (W.devicePixelRatio || 1) <= 1 ? "translate("+g+"px, "+b+"px)" : "translate3d("+g+"px, "+b+"px, 0)", R)) : Object.assign({}, S, ((n = {})[M] = L ? b+"px" : "", n[P] = w ? g+"px" : "", n.transform = "", n))
    }

    var ne = {
        name: "computeStyles", enabled: !0, phase: "beforeWrite", fn: function (e) {
            var t = e.state, n = e.options, r = n.gpuAcceleration, o = void 0 === r || r, i = n.adaptive,
                a = void 0 === i || i, s = n.roundOffsets, f = void 0 === s || s, c = {
                    placement: C(t.placement),
                    variation: _(t.placement),
                    popper: t.elements.popper,
                    popperRect: t.rects.popper,
                    gpuAcceleration: o,
                    isFixed: "fixed" === t.options.strategy
                };
            null != t.modifiersData.popperOffsets && (t.styles.popper = Object.assign({}, t.styles.popper, te(Object.assign({}, c, {
                offsets: t.modifiersData.popperOffsets,
                position: t.options.strategy,
                adaptive: a,
                roundOffsets: f
            })))), null != t.modifiersData.arrow && (t.styles.arrow = Object.assign({}, t.styles.arrow, te(Object.assign({}, c, {
                offsets: t.modifiersData.arrow,
                position: "absolute",
                adaptive: !1,
                roundOffsets: f
            })))), t.attributes.popper = Object.assign({}, t.attributes.popper, {"data-popper-placement": t.placement})
        }, data: {}
    };
    var re = {
        name: "applyStyles", enabled: !0, phase: "write", fn: function (e) {
            var t = e.state;
            Object.keys(t.elements).forEach((function (e) {
                var n = t.styles[e] || {}, o = t.attributes[e] || {}, i = t.elements[e];
                r(i) && p(i) && (Object.assign(i.style, n), Object.keys(o).forEach((function (e) {
                    var t = o[e];
                    !1 === t ? i.removeAttribute(e) : i.setAttribute(e, !0 === t ? "" : t)
                })))
            }))
        }, effect: function (e) {
            var t = e.state, n = {
                popper: {position: t.options.strategy, left: "0", top: "0", margin: "0"},
                arrow: {position: "absolute"},
                reference: {}
            };
            return Object.assign(t.elements.popper.style, n.popper), t.styles = n, t.elements.arrow && Object.assign(t.elements.arrow.style, n.arrow), function () {
                Object.keys(t.elements).forEach((function (e) {
                    var o = t.elements[e], i = t.attributes[e] || {},
                        a = Object.keys(t.styles.hasOwnProperty(e) ? t.styles[e] : n[e]).reduce((function (e, t) {
                            return e[t] = "", e
                        }), {});
                    r(o) && p(o) && (Object.assign(o.style, a), Object.keys(i).forEach((function (e) {
                        o.removeAttribute(e)
                    })))
                }))
            }
        }, requires: ["computeStyles"]
    };
    var oe = {
        name: "offset", enabled: !0, phase: "main", requires: ["popperOffsets"], fn: function (e) {
            var t = e.state, n = e.options, r = e.name, o = n.offset, i = void 0 === o ? [0, 0] : o,
                a = T.reduce((function (e, n) {
                    return e[n] = function (e, t, n) {
                        var r = C(e), o = [A, j].indexOf(r) >= 0 ? -1 : 1,
                            i = "function" == typeof n ? n(Object.assign({}, t, {placement: e})) : n, a = i[0],
                            s = i[1];
                        return a = a || 0, s = (s || 0) * o, [A, D].indexOf(r) >= 0 ? {x: s, y: a} : {x: a, y: s}
                    }(n, t.rects, i), e
                }), {}), s = a[t.placement], f = s.x, c = s.y;
            null != t.modifiersData.popperOffsets && (t.modifiersData.popperOffsets.x += f, t.modifiersData.popperOffsets.y += c), t.modifiersData[r] = a
        }
    }, ie = {left: "right", right: "left", bottom: "top", top: "bottom"};

    function ae(e) {
        return e.replace(/left|right|bottom|top/g, (function (e) {
            return ie[e]
        }))
    }

    var se = {start: "end", end: "start"};

    function fe(e) {
        return e.replace(/start|end/g, (function (e) {
            return se[e]
        }))
    }

    function ce(e, t) {
        void 0 === t && (t = {});
        var n = t, r = n.placement, o = n.boundary, i = n.rootBoundary, a = n.padding, s = n.flipVariations,
            f = n.allowedAutoPlacements, c = void 0 === f ? T : f, p = _(r), u = p ? s ? H : H.filter((function (e) {
                return _(e) === p
            })) : P, l = u.filter((function (e) {
                return c.indexOf(e) >= 0
            }));
        0 === l.length && (l = u);
        var d = l.reduce((function (t, n) {
            return t[n] = Y(e, {placement: n, boundary: o, rootBoundary: i, padding: a})[C(n)], t
        }), {});
        return Object.keys(d).sort((function (e, t) {
            return d[e]-d[t]
        }))
    }

    var pe = {
        name: "flip", enabled: !0, phase: "main", fn: function (e) {
            var t = e.state, n = e.options, r = e.name;
            if (!t.modifiersData[r]._skip) {
                for (var o = n.mainAxis, i = void 0 === o || o, a = n.altAxis, s = void 0 === a || a, f = n.fallbackPlacements, c = n.padding, p = n.boundary, u = n.rootBoundary, l = n.altBoundary, d = n.flipVariations, h = void 0 === d || d, m = n.allowedAutoPlacements, v = t.options.placement, g = C(v), y = f || (g === v || !h ? [ae(v)] : function (e) {
                    if (C(e) === L) return [];
                    var t = ae(e);
                    return [fe(e), t, fe(t)]
                }(v)), b = [v].concat(y).reduce((function (e, n) {
                    return e.concat(C(n) === L ? ce(t, {
                        placement: n,
                        boundary: p,
                        rootBoundary: u,
                        padding: c,
                        flipVariations: h,
                        allowedAutoPlacements: m
                    }) : n)
                }), []), x = t.rects.reference, w = t.rects.popper, O = new Map, P = !0, k = b[0], W = 0; W < b.length; W++) {
                    var B = b[W], H = C(B), T = _(B) === M, R = [j, E].indexOf(H) >= 0, S = R ? "width" : "height",
                        q = Y(t, {placement: B, boundary: p, rootBoundary: u, altBoundary: l, padding: c}),
                        V = R ? T ? D : A : T ? E : j;
                    x[S] > w[S] && (V = ae(V));
                    var N = ae(V), I = [];
                    if (i && I.push(q[H] <= 0), s && I.push(q[V] <= 0, q[N] <= 0), I.every((function (e) {
                        return e
                    }))) {
                        k = B, P = !1;
                        break
                    }
                    O.set(B, I)
                }
                if (P) for (var F = function (e) {
                    var t = b.find((function (t) {
                        var n = O.get(t);
                        if (n) return n.slice(0, e).every((function (e) {
                            return e
                        }))
                    }));
                    if (t) return k = t, "break"
                }, U = h ? 3 : 1; U > 0; U--) {
                    if ("break" === F(U)) break
                }
                t.placement !== k && (t.modifiersData[r]._skip = !0, t.placement = k, t.reset = !0)
            }
        }, requiresIfExists: ["offset"], data: {_skip: !1}
    };

    function ue(e, t, n) {
        return i(e, a(t, n))
    }

    var le = {
        name: "preventOverflow", enabled: !0, phase: "main", fn: function (e) {
            var t = e.state, n = e.options, r = e.name, o = n.mainAxis, s = void 0 === o || o, f = n.altAxis,
                c = void 0 !== f && f, p = n.boundary, u = n.rootBoundary, l = n.altBoundary, d = n.padding,
                h = n.tether, m = void 0 === h || h, g = n.tetherOffset, y = void 0 === g ? 0 : g,
                b = Y(t, {boundary: p, rootBoundary: u, padding: d, altBoundary: l}), x = C(t.placement),
                w = _(t.placement), L = !w, P = F(x), k = "x" === P ? "y" : "x", W = t.modifiersData.popperOffsets,
                B = t.rects.reference, H = t.rects.popper,
                T = "function" == typeof y ? y(Object.assign({}, t.rects, {placement: t.placement})) : y,
                R = "number" == typeof T ? {mainAxis: T, altAxis: T} : Object.assign({mainAxis: 0, altAxis: 0}, T),
                S = t.modifiersData.offset ? t.modifiersData.offset[t.placement] : null, q = {x: 0, y: 0};
            if (W) {
                if (s) {
                    var V, N = "y" === P ? j : A, I = "y" === P ? E : D, U = "y" === P ? "height" : "width", z = W[P],
                        X = z+b[N], G = z-b[I], J = m ? -H[U] / 2 : 0, K = w === M ? B[U] : H[U],
                        Q = w === M ? -H[U] : -B[U], Z = t.elements.arrow, $ = m && Z ? v(Z) : {width: 0, height: 0},
                        ee = t.modifiersData["arrow#persistent"] ? t.modifiersData["arrow#persistent"].padding : {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }, te = ee[N], ne = ee[I], re = ue(0, B[U], $[U]),
                        oe = L ? B[U] / 2-J-re-te-R.mainAxis : K-re-te-R.mainAxis,
                        ie = L ? -B[U] / 2+J+re+ne+R.mainAxis : Q+re+ne+R.mainAxis,
                        ae = t.elements.arrow && O(t.elements.arrow),
                        se = ae ? "y" === P ? ae.clientTop || 0 : ae.clientLeft || 0 : 0,
                        fe = null != (V = null == S ? void 0 : S[P]) ? V : 0, ce = z+ie-fe,
                        pe = ue(m ? a(X, z+oe-fe-se) : X, z, m ? i(G, ce) : G);
                    W[P] = pe, q[P] = pe-z
                }
                if (c) {
                    var le, de = "x" === P ? j : A, he = "x" === P ? E : D, me = W[k],
                        ve = "y" === k ? "height" : "width", ge = me+b[de], ye = me-b[he],
                        be = -1 !== [j, A].indexOf(x), xe = null != (le = null == S ? void 0 : S[k]) ? le : 0,
                        we = be ? ge : me-B[ve]-H[ve]-xe+R.altAxis, Oe = be ? me+B[ve]+H[ve]-xe-R.altAxis : ye,
                        je = m && be ? function (e, t, n) {
                            var r = ue(e, t, n);
                            return r > n ? n : r
                        }(we, me, Oe) : ue(m ? we : ge, me, m ? Oe : ye);
                    W[k] = je, q[k] = je-me
                }
                t.modifiersData[r] = q
            }
        }, requiresIfExists: ["offset"]
    };
    var de = {
        name: "arrow", enabled: !0, phase: "main", fn: function (e) {
            var t, n = e.state, r = e.name, o = e.options, i = n.elements.arrow, a = n.modifiersData.popperOffsets,
                s = C(n.placement), f = F(s), c = [A, D].indexOf(s) >= 0 ? "height" : "width";
            if (i && a) {
                var p = function (e, t) {
                        return z("number" != typeof (e = "function" == typeof e ? e(Object.assign({}, t.rects, {placement: t.placement})) : e) ? e : X(e, P))
                    }(o.padding, n), u = v(i), l = "y" === f ? j : A, d = "y" === f ? E : D,
                    h = n.rects.reference[c]+n.rects.reference[f]-a[f]-n.rects.popper[c], m = a[f]-n.rects.reference[f],
                    g = O(i), y = g ? "y" === f ? g.clientHeight || 0 : g.clientWidth || 0 : 0, b = h / 2-m / 2,
                    x = p[l], w = y-u[c]-p[d], L = y / 2-u[c] / 2+b, M = ue(x, L, w), k = f;
                n.modifiersData[r] = ((t = {})[k] = M, t.centerOffset = M-L, t)
            }
        }, effect: function (e) {
            var t = e.state, n = e.options.element, r = void 0 === n ? "[data-popper-arrow]" : n;
            null != r && ("string" != typeof r || (r = t.elements.popper.querySelector(r))) && q(t.elements.popper, r) && (t.elements.arrow = r)
        }, requires: ["popperOffsets"], requiresIfExists: ["preventOverflow"]
    };

    function he(e, t, n) {
        return void 0 === n && (n = {x: 0, y: 0}), {
            top: e.top-t.height-n.y,
            right: e.right-t.width+n.x,
            bottom: e.bottom-t.height+n.y,
            left: e.left-t.width-n.x
        }
    }

    function me(e) {
        return [j, D, E, A].some((function (t) {
            return e[t] >= 0
        }))
    }

    var ve = {
            name: "hide", enabled: !0, phase: "main", requiresIfExists: ["preventOverflow"], fn: function (e) {
                var t = e.state, n = e.name, r = t.rects.reference, o = t.rects.popper, i = t.modifiersData.preventOverflow,
                    a = Y(t, {elementContext: "reference"}), s = Y(t, {altBoundary: !0}), f = he(a, r), c = he(s, o, i),
                    p = me(f), u = me(c);
                t.modifiersData[n] = {
                    referenceClippingOffsets: f,
                    popperEscapeOffsets: c,
                    isReferenceHidden: p,
                    hasPopperEscaped: u
                }, t.attributes.popper = Object.assign({}, t.attributes.popper, {
                    "data-popper-reference-hidden": p,
                    "data-popper-escaped": u
                })
            }
        }, ge = K({defaultModifiers: [Z, $, ne, re]}), ye = [Z, $, ne, re, oe, pe, le, de, ve],
        be = K({defaultModifiers: ye});
    e.applyStyles = re, e.arrow = de, e.computeStyles = ne, e.createPopper = be, e.createPopperLite = ge, e.defaultModifiers = ye, e.detectOverflow = Y, e.eventListeners = Z, e.flip = pe, e.hide = ve, e.offset = oe, e.popperGenerator = K, e.popperOffsets = $, e.preventOverflow = le, Object.defineProperty(e, "__esModule", {value: !0})
}));
//# sourceMappingURL=popper.min.js.map

/*!
  * Bootstrap v5.1.3 (https://getbootstrap.com/)
  * Copyright 2011-2021 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */
!function (t, e) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = e(require("@popperjs/core")) : "function" == typeof define && define.amd ? define(["@popperjs/core"], e) : (t = "undefined" != typeof globalThis ? globalThis : t || self).bootstrap = e(t.Popper)
}(this, (function (t) {
    "use strict";

    function e(t) {
        if (t && t.__esModule) return t;
        const e = Object.create(null);
        if (t) for (const i in t) if ("default" !== i) {
            const s = Object.getOwnPropertyDescriptor(t, i);
            Object.defineProperty(e, i, s.get ? s : {enumerable: !0, get: () => t[i]})
        }
        return e.default = t, Object.freeze(e)
    }

    const i = e(t), s = "transitionend", n = t => {
            let e = t.getAttribute("data-bs-target");
            if (!e || "#" === e) {
                let i = t.getAttribute("href");
                if (!i || !i.includes("#") && !i.startsWith(".")) return null;
                i.includes("#") && !i.startsWith("#") && (i = `#${i.split("#")[1]}`), e = i && "#" !== i ? i.trim() : null
            }
            return e
        }, o = t => {
            const e = n(t);
            return e && document.querySelector(e) ? e : null
        }, r = t => {
            const e = n(t);
            return e ? document.querySelector(e) : null
        }, a = t => {
            t.dispatchEvent(new Event(s))
        }, l = t => !(!t || "object" != typeof t) && (void 0 !== t.jquery && (t = t[0]), void 0 !== t.nodeType),
        c = t => l(t) ? t.jquery ? t[0] : t : "string" == typeof t && t.length > 0 ? document.querySelector(t) : null,
        h = (t, e, i) => {
            Object.keys(i).forEach((s => {
                const n = i[s], o = e[s],
                    r = o && l(o) ? "element" : null == (a = o) ? `${a}` : {}.toString.call(a).match(/\s([a-z]+)/i)[1].toLowerCase();
                var a;
                if (!new RegExp(n).test(r)) throw new TypeError(`${t.toUpperCase()}: Option "${s}" provided type "${r}" but expected type "${n}".`)
            }))
        },
        d = t => !(!l(t) || 0 === t.getClientRects().length) && "visible" === getComputedStyle(t).getPropertyValue("visibility"),
        u = t => !t || t.nodeType !== Node.ELEMENT_NODE || !!t.classList.contains("disabled") || (void 0 !== t.disabled ? t.disabled : t.hasAttribute("disabled") && "false" !== t.getAttribute("disabled")),
        g = t => {
            if (!document.documentElement.attachShadow) return null;
            if ("function" == typeof t.getRootNode) {
                const e = t.getRootNode();
                return e instanceof ShadowRoot ? e : null
            }
            return t instanceof ShadowRoot ? t : t.parentNode ? g(t.parentNode) : null
        }, _ = () => {
        }, f = t => {
            t.offsetHeight
        }, p = () => {
            const {jQuery: t} = window;
            return t && !document.body.hasAttribute("data-bs-no-jquery") ? t : null
        }, m = [], b = () => "rtl" === document.documentElement.dir, v = t => {
            var e;
            e = () => {
                const e = p();
                if (e) {
                    const i = t.NAME, s = e.fn[i];
                    e.fn[i] = t.jQueryInterface, e.fn[i].Constructor = t, e.fn[i].noConflict = () => (e.fn[i] = s, t.jQueryInterface)
                }
            }, "loading" === document.readyState ? (m.length || document.addEventListener("DOMContentLoaded", (() => {
                m.forEach((t => t()))
            })), m.push(e)) : e()
        }, y = t => {
            "function" == typeof t && t()
        }, E = (t, e, i = !0) => {
            if (!i) return void y(t);
            const n = (t => {
                if (!t) return 0;
                let {transitionDuration: e, transitionDelay: i} = window.getComputedStyle(t);
                const s = Number.parseFloat(e), n = Number.parseFloat(i);
                return s || n ? (e = e.split(",")[0], i = i.split(",")[0], 1e3 * (Number.parseFloat(e)+Number.parseFloat(i))) : 0
            })(e)+5;
            let o = !1;
            const r = ({target: i}) => {
                i === e && (o = !0, e.removeEventListener(s, r), y(t))
            };
            e.addEventListener(s, r), setTimeout((() => {
                o || a(e)
            }), n)
        }, w = (t, e, i, s) => {
            let n = t.indexOf(e);
            if (-1 === n) return t[!i && s ? t.length-1 : 0];
            const o = t.length;
            return n += i ? 1 : -1, s && (n = (n+o) % o), t[Math.max(0, Math.min(n, o-1))]
        }, A = /[^.]*(?=\..*)\.|.*/, T = /\..*/, C = /::\d+$/, k = {};
    let L = 1;
    const S = {mouseenter: "mouseover", mouseleave: "mouseout"}, O = /^(mouseenter|mouseleave)/i,
        N = new Set(["click", "dblclick", "mouseup", "mousedown", "contextmenu", "mousewheel", "DOMMouseScroll", "mouseover", "mouseout", "mousemove", "selectstart", "selectend", "keydown", "keypress", "keyup", "orientationchange", "touchstart", "touchmove", "touchend", "touchcancel", "pointerdown", "pointermove", "pointerup", "pointerleave", "pointercancel", "gesturestart", "gesturechange", "gestureend", "focus", "blur", "change", "reset", "select", "submit", "focusin", "focusout", "load", "unload", "beforeunload", "resize", "move", "DOMContentLoaded", "readystatechange", "error", "abort", "scroll"]);

    function D(t, e) {
        return e && `${e}::${L++}` || t.uidEvent || L++
    }

    function I(t) {
        const e = D(t);
        return t.uidEvent = e, k[e] = k[e] || {}, k[e]
    }

    function P(t, e, i = null) {
        const s = Object.keys(t);
        for (let n = 0, o = s.length; n < o; n++) {
            const o = t[s[n]];
            if (o.originalHandler === e && o.delegationSelector === i) return o
        }
        return null
    }

    function x(t, e, i) {
        const s = "string" == typeof e, n = s ? i : e;
        let o = H(t);
        return N.has(o) || (o = t), [s, n, o]
    }

    function M(t, e, i, s, n) {
        if ("string" != typeof e || !t) return;
        if (i || (i = s, s = null), O.test(e)) {
            const t = t => function (e) {
                if (!e.relatedTarget || e.relatedTarget !== e.delegateTarget && !e.delegateTarget.contains(e.relatedTarget)) return t.call(this, e)
            };
            s ? s = t(s) : i = t(i)
        }
        const [o, r, a] = x(e, i, s), l = I(t), c = l[a] || (l[a] = {}), h = P(c, r, o ? i : null);
        if (h) return void (h.oneOff = h.oneOff && n);
        const d = D(r, e.replace(A, "")), u = o ? function (t, e, i) {
            return function s(n) {
                const o = t.querySelectorAll(e);
                for (let {target: r} = n; r && r !== this; r = r.parentNode) for (let a = o.length; a--;) if (o[a] === r) return n.delegateTarget = r, s.oneOff && $.off(t, n.type, e, i), i.apply(r, [n]);
                return null
            }
        }(t, i, s) : function (t, e) {
            return function i(s) {
                return s.delegateTarget = t, i.oneOff && $.off(t, s.type, e), e.apply(t, [s])
            }
        }(t, i);
        u.delegationSelector = o ? i : null, u.originalHandler = r, u.oneOff = n, u.uidEvent = d, c[d] = u, t.addEventListener(a, u, o)
    }

    function j(t, e, i, s, n) {
        const o = P(e[i], s, n);
        o && (t.removeEventListener(i, o, Boolean(n)), delete e[i][o.uidEvent])
    }

    function H(t) {
        return t = t.replace(T, ""), S[t] || t
    }

    const $ = {
        on(t, e, i, s) {
            M(t, e, i, s, !1)
        }, one(t, e, i, s) {
            M(t, e, i, s, !0)
        }, off(t, e, i, s) {
            if ("string" != typeof e || !t) return;
            const [n, o, r] = x(e, i, s), a = r !== e, l = I(t), c = e.startsWith(".");
            if (void 0 !== o) {
                if (!l || !l[r]) return;
                return void j(t, l, r, o, n ? i : null)
            }
            c && Object.keys(l).forEach((i => {
                !function (t, e, i, s) {
                    const n = e[i] || {};
                    Object.keys(n).forEach((o => {
                        if (o.includes(s)) {
                            const s = n[o];
                            j(t, e, i, s.originalHandler, s.delegationSelector)
                        }
                    }))
                }(t, l, i, e.slice(1))
            }));
            const h = l[r] || {};
            Object.keys(h).forEach((i => {
                const s = i.replace(C, "");
                if (!a || e.includes(s)) {
                    const e = h[i];
                    j(t, l, r, e.originalHandler, e.delegationSelector)
                }
            }))
        }, trigger(t, e, i) {
            if ("string" != typeof e || !t) return null;
            const s = p(), n = H(e), o = e !== n, r = N.has(n);
            let a, l = !0, c = !0, h = !1, d = null;
            return o && s && (a = s.Event(e, i), s(t).trigger(a), l = !a.isPropagationStopped(), c = !a.isImmediatePropagationStopped(), h = a.isDefaultPrevented()), r ? (d = document.createEvent("HTMLEvents"), d.initEvent(n, l, !0)) : d = new CustomEvent(e, {
                bubbles: l,
                cancelable: !0
            }), void 0 !== i && Object.keys(i).forEach((t => {
                Object.defineProperty(d, t, {get: () => i[t]})
            })), h && d.preventDefault(), c && t.dispatchEvent(d), d.defaultPrevented && void 0 !== a && a.preventDefault(), d
        }
    }, B = new Map, z = {
        set(t, e, i) {
            B.has(t) || B.set(t, new Map);
            const s = B.get(t);
            s.has(e) || 0 === s.size ? s.set(e, i) : console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(s.keys())[0]}.`)
        }, get: (t, e) => B.has(t) && B.get(t).get(e) || null, remove(t, e) {
            if (!B.has(t)) return;
            const i = B.get(t);
            i.delete(e), 0 === i.size && B.delete(t)
        }
    };

    class R {
        constructor(t) {
            (t = c(t)) && (this._element = t, z.set(this._element, this.constructor.DATA_KEY, this))
        }

        dispose() {
            z.remove(this._element, this.constructor.DATA_KEY), $.off(this._element, this.constructor.EVENT_KEY), Object.getOwnPropertyNames(this).forEach((t => {
                this[t] = null
            }))
        }

        _queueCallback(t, e, i = !0) {
            E(t, e, i)
        }

        static getInstance(t) {
            return z.get(c(t), this.DATA_KEY)
        }

        static getOrCreateInstance(t, e = {}) {
            return this.getInstance(t) || new this(t, "object" == typeof e ? e : null)
        }

        static get VERSION() {
            return "5.1.3"
        }

        static get NAME() {
            throw new Error('You have to implement the static method "NAME", for each component!')
        }

        static get DATA_KEY() {
            return `bs.${this.NAME}`
        }

        static get EVENT_KEY() {
            return `.${this.DATA_KEY}`
        }
    }

    const F = (t, e = "hide") => {
        const i = `click.dismiss${t.EVENT_KEY}`, s = t.NAME;
        $.on(document, i, `[data-bs-dismiss="${s}"]`, (function (i) {
            if (["A", "AREA"].includes(this.tagName) && i.preventDefault(), u(this)) return;
            const n = r(this) || this.closest(`.${s}`);
            t.getOrCreateInstance(n)[e]()
        }))
    };

    class q extends R {
        static get NAME() {
            return "alert"
        }

        close() {
            if ($.trigger(this._element, "close.bs.alert").defaultPrevented) return;
            this._element.classList.remove("show");
            const t = this._element.classList.contains("fade");
            this._queueCallback((() => this._destroyElement()), this._element, t)
        }

        _destroyElement() {
            this._element.remove(), $.trigger(this._element, "closed.bs.alert"), this.dispose()
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = q.getOrCreateInstance(this);
                if ("string" == typeof t) {
                    if (void 0 === e[t] || t.startsWith("_") || "constructor" === t) throw new TypeError(`No method named "${t}"`);
                    e[t](this)
                }
            }))
        }
    }

    F(q, "close"), v(q);
    const W = '[data-bs-toggle="button"]';

    class U extends R {
        static get NAME() {
            return "button"
        }

        toggle() {
            this._element.setAttribute("aria-pressed", this._element.classList.toggle("active"))
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = U.getOrCreateInstance(this);
                "toggle" === t && e[t]()
            }))
        }
    }

    function K(t) {
        return "true" === t || "false" !== t && (t === Number(t).toString() ? Number(t) : "" === t || "null" === t ? null : t)
    }

    function V(t) {
        return t.replace(/[A-Z]/g, (t => `-${t.toLowerCase()}`))
    }

    $.on(document, "click.bs.button.data-api", W, (t => {
        t.preventDefault();
        const e = t.target.closest(W);
        U.getOrCreateInstance(e).toggle()
    })), v(U);
    const X = {
            setDataAttribute(t, e, i) {
                t.setAttribute(`data-bs-${V(e)}`, i)
            }, removeDataAttribute(t, e) {
                t.removeAttribute(`data-bs-${V(e)}`)
            }, getDataAttributes(t) {
                if (!t) return {};
                const e = {};
                return Object.keys(t.dataset).filter((t => t.startsWith("bs"))).forEach((i => {
                    let s = i.replace(/^bs/, "");
                    s = s.charAt(0).toLowerCase()+s.slice(1, s.length), e[s] = K(t.dataset[i])
                })), e
            }, getDataAttribute: (t, e) => K(t.getAttribute(`data-bs-${V(e)}`)), offset(t) {
                const e = t.getBoundingClientRect();
                return {top: e.top+window.pageYOffset, left: e.left+window.pageXOffset}
            }, position: t => ({top: t.offsetTop, left: t.offsetLeft})
        }, Y = {
            find: (t, e = document.documentElement) => [].concat(...Element.prototype.querySelectorAll.call(e, t)),
            findOne: (t, e = document.documentElement) => Element.prototype.querySelector.call(e, t),
            children: (t, e) => [].concat(...t.children).filter((t => t.matches(e))),
            parents(t, e) {
                const i = [];
                let s = t.parentNode;
                for (; s && s.nodeType === Node.ELEMENT_NODE && 3 !== s.nodeType;) s.matches(e) && i.push(s), s = s.parentNode;
                return i
            },
            prev(t, e) {
                let i = t.previousElementSibling;
                for (; i;) {
                    if (i.matches(e)) return [i];
                    i = i.previousElementSibling
                }
                return []
            },
            next(t, e) {
                let i = t.nextElementSibling;
                for (; i;) {
                    if (i.matches(e)) return [i];
                    i = i.nextElementSibling
                }
                return []
            },
            focusableChildren(t) {
                const e = ["a", "button", "input", "textarea", "select", "details", "[tabindex]", '[contenteditable="true"]'].map((t => `${t}:not([tabindex^="-"])`)).join(", ");
                return this.find(e, t).filter((t => !u(t) && d(t)))
            }
        }, Q = "carousel", G = {interval: 5e3, keyboard: !0, slide: !1, pause: "hover", wrap: !0, touch: !0}, Z = {
            interval: "(number|boolean)",
            keyboard: "boolean",
            slide: "(boolean|string)",
            pause: "(string|boolean)",
            wrap: "boolean",
            touch: "boolean"
        }, J = "next", tt = "prev", et = "left", it = "right", st = {ArrowLeft: it, ArrowRight: et},
        nt = "slid.bs.carousel", ot = "active", rt = ".active.carousel-item";

    class at extends R {
        constructor(t, e) {
            super(t), this._items = null, this._interval = null, this._activeElement = null, this._isPaused = !1, this._isSliding = !1, this.touchTimeout = null, this.touchStartX = 0, this.touchDeltaX = 0, this._config = this._getConfig(e), this._indicatorsElement = Y.findOne(".carousel-indicators", this._element), this._touchSupported = "ontouchstart" in document.documentElement || navigator.maxTouchPoints > 0, this._pointerEvent = Boolean(window.PointerEvent), this._addEventListeners()
        }

        static get Default() {
            return G
        }

        static get NAME() {
            return Q
        }

        next() {
            this._slide(J)
        }

        nextWhenVisible() {
            !document.hidden && d(this._element) && this.next()
        }

        prev() {
            this._slide(tt)
        }

        pause(t) {
            t || (this._isPaused = !0), Y.findOne(".carousel-item-next, .carousel-item-prev", this._element) && (a(this._element), this.cycle(!0)), clearInterval(this._interval), this._interval = null
        }

        cycle(t) {
            t || (this._isPaused = !1), this._interval && (clearInterval(this._interval), this._interval = null), this._config && this._config.interval && !this._isPaused && (this._updateInterval(), this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval))
        }

        to(t) {
            this._activeElement = Y.findOne(rt, this._element);
            const e = this._getItemIndex(this._activeElement);
            if (t > this._items.length-1 || t < 0) return;
            if (this._isSliding) return void $.one(this._element, nt, (() => this.to(t)));
            if (e === t) return this.pause(), void this.cycle();
            const i = t > e ? J : tt;
            this._slide(i, this._items[t])
        }

        _getConfig(t) {
            return t = {...G, ...X.getDataAttributes(this._element), ..."object" == typeof t ? t : {}}, h(Q, t, Z), t
        }

        _handleSwipe() {
            const t = Math.abs(this.touchDeltaX);
            if (t <= 40) return;
            const e = t / this.touchDeltaX;
            this.touchDeltaX = 0, e && this._slide(e > 0 ? it : et)
        }

        _addEventListeners() {
            this._config.keyboard && $.on(this._element, "keydown.bs.carousel", (t => this._keydown(t))), "hover" === this._config.pause && ($.on(this._element, "mouseenter.bs.carousel", (t => this.pause(t))), $.on(this._element, "mouseleave.bs.carousel", (t => this.cycle(t)))), this._config.touch && this._touchSupported && this._addTouchEventListeners()
        }

        _addTouchEventListeners() {
            const t = t => this._pointerEvent && ("pen" === t.pointerType || "touch" === t.pointerType), e = e => {
                t(e) ? this.touchStartX = e.clientX : this._pointerEvent || (this.touchStartX = e.touches[0].clientX)
            }, i = t => {
                this.touchDeltaX = t.touches && t.touches.length > 1 ? 0 : t.touches[0].clientX-this.touchStartX
            }, s = e => {
                t(e) && (this.touchDeltaX = e.clientX-this.touchStartX), this._handleSwipe(), "hover" === this._config.pause && (this.pause(), this.touchTimeout && clearTimeout(this.touchTimeout), this.touchTimeout = setTimeout((t => this.cycle(t)), 500+this._config.interval))
            };
            Y.find(".carousel-item img", this._element).forEach((t => {
                $.on(t, "dragstart.bs.carousel", (t => t.preventDefault()))
            })), this._pointerEvent ? ($.on(this._element, "pointerdown.bs.carousel", (t => e(t))), $.on(this._element, "pointerup.bs.carousel", (t => s(t))), this._element.classList.add("pointer-event")) : ($.on(this._element, "touchstart.bs.carousel", (t => e(t))), $.on(this._element, "touchmove.bs.carousel", (t => i(t))), $.on(this._element, "touchend.bs.carousel", (t => s(t))))
        }

        _keydown(t) {
            if (/input|textarea/i.test(t.target.tagName)) return;
            const e = st[t.key];
            e && (t.preventDefault(), this._slide(e))
        }

        _getItemIndex(t) {
            return this._items = t && t.parentNode ? Y.find(".carousel-item", t.parentNode) : [], this._items.indexOf(t)
        }

        _getItemByOrder(t, e) {
            const i = t === J;
            return w(this._items, e, i, this._config.wrap)
        }

        _triggerSlideEvent(t, e) {
            const i = this._getItemIndex(t), s = this._getItemIndex(Y.findOne(rt, this._element));
            return $.trigger(this._element, "slide.bs.carousel", {relatedTarget: t, direction: e, from: s, to: i})
        }

        _setActiveIndicatorElement(t) {
            if (this._indicatorsElement) {
                const e = Y.findOne(".active", this._indicatorsElement);
                e.classList.remove(ot), e.removeAttribute("aria-current");
                const i = Y.find("[data-bs-target]", this._indicatorsElement);
                for (let e = 0; e < i.length; e++) if (Number.parseInt(i[e].getAttribute("data-bs-slide-to"), 10) === this._getItemIndex(t)) {
                    i[e].classList.add(ot), i[e].setAttribute("aria-current", "true");
                    break
                }
            }
        }

        _updateInterval() {
            const t = this._activeElement || Y.findOne(rt, this._element);
            if (!t) return;
            const e = Number.parseInt(t.getAttribute("data-bs-interval"), 10);
            e ? (this._config.defaultInterval = this._config.defaultInterval || this._config.interval, this._config.interval = e) : this._config.interval = this._config.defaultInterval || this._config.interval
        }

        _slide(t, e) {
            const i = this._directionToOrder(t), s = Y.findOne(rt, this._element), n = this._getItemIndex(s),
                o = e || this._getItemByOrder(i, s), r = this._getItemIndex(o), a = Boolean(this._interval),
                l = i === J, c = l ? "carousel-item-start" : "carousel-item-end",
                h = l ? "carousel-item-next" : "carousel-item-prev", d = this._orderToDirection(i);
            if (o && o.classList.contains(ot)) return void (this._isSliding = !1);
            if (this._isSliding) return;
            if (this._triggerSlideEvent(o, d).defaultPrevented) return;
            if (!s || !o) return;
            this._isSliding = !0, a && this.pause(), this._setActiveIndicatorElement(o), this._activeElement = o;
            const u = () => {
                $.trigger(this._element, nt, {relatedTarget: o, direction: d, from: n, to: r})
            };
            if (this._element.classList.contains("slide")) {
                o.classList.add(h), f(o), s.classList.add(c), o.classList.add(c);
                const t = () => {
                    o.classList.remove(c, h), o.classList.add(ot), s.classList.remove(ot, h, c), this._isSliding = !1, setTimeout(u, 0)
                };
                this._queueCallback(t, s, !0)
            } else s.classList.remove(ot), o.classList.add(ot), this._isSliding = !1, u();
            a && this.cycle()
        }

        _directionToOrder(t) {
            return [it, et].includes(t) ? b() ? t === et ? tt : J : t === et ? J : tt : t
        }

        _orderToDirection(t) {
            return [J, tt].includes(t) ? b() ? t === tt ? et : it : t === tt ? it : et : t
        }

        static carouselInterface(t, e) {
            const i = at.getOrCreateInstance(t, e);
            let {_config: s} = i;
            "object" == typeof e && (s = {...s, ...e});
            const n = "string" == typeof e ? e : s.slide;
            if ("number" == typeof e) i.to(e); else if ("string" == typeof n) {
                if (void 0 === i[n]) throw new TypeError(`No method named "${n}"`);
                i[n]()
            } else s.interval && s.ride && (i.pause(), i.cycle())
        }

        static jQueryInterface(t) {
            return this.each((function () {
                at.carouselInterface(this, t)
            }))
        }

        static dataApiClickHandler(t) {
            const e = r(this);
            if (!e || !e.classList.contains("carousel")) return;
            const i = {...X.getDataAttributes(e), ...X.getDataAttributes(this)},
                s = this.getAttribute("data-bs-slide-to");
            s && (i.interval = !1), at.carouselInterface(e, i), s && at.getInstance(e).to(s), t.preventDefault()
        }
    }

    $.on(document, "click.bs.carousel.data-api", "[data-bs-slide], [data-bs-slide-to]", at.dataApiClickHandler), $.on(window, "load.bs.carousel.data-api", (() => {
        const t = Y.find('[data-bs-ride="carousel"]');
        for (let e = 0, i = t.length; e < i; e++) at.carouselInterface(t[e], at.getInstance(t[e]))
    })), v(at);
    const lt = "collapse", ct = {toggle: !0, parent: null}, ht = {toggle: "boolean", parent: "(null|element)"},
        dt = "show", ut = "collapse", gt = "collapsing", _t = "collapsed", ft = ":scope .collapse .collapse",
        pt = '[data-bs-toggle="collapse"]';

    class mt extends R {
        constructor(t, e) {
            super(t), this._isTransitioning = !1, this._config = this._getConfig(e), this._triggerArray = [];
            const i = Y.find(pt);
            for (let t = 0, e = i.length; t < e; t++) {
                const e = i[t], s = o(e), n = Y.find(s).filter((t => t === this._element));
                null !== s && n.length && (this._selector = s, this._triggerArray.push(e))
            }
            this._initializeChildren(), this._config.parent || this._addAriaAndCollapsedClass(this._triggerArray, this._isShown()), this._config.toggle && this.toggle()
        }

        static get Default() {
            return ct
        }

        static get NAME() {
            return lt
        }

        toggle() {
            this._isShown() ? this.hide() : this.show()
        }

        show() {
            if (this._isTransitioning || this._isShown()) return;
            let t, e = [];
            if (this._config.parent) {
                const t = Y.find(ft, this._config.parent);
                e = Y.find(".collapse.show, .collapse.collapsing", this._config.parent).filter((e => !t.includes(e)))
            }
            const i = Y.findOne(this._selector);
            if (e.length) {
                const s = e.find((t => i !== t));
                if (t = s ? mt.getInstance(s) : null, t && t._isTransitioning) return
            }
            if ($.trigger(this._element, "show.bs.collapse").defaultPrevented) return;
            e.forEach((e => {
                i !== e && mt.getOrCreateInstance(e, {toggle: !1}).hide(), t || z.set(e, "bs.collapse", null)
            }));
            const s = this._getDimension();
            this._element.classList.remove(ut), this._element.classList.add(gt), this._element.style[s] = 0, this._addAriaAndCollapsedClass(this._triggerArray, !0), this._isTransitioning = !0;
            const n = `scroll${s[0].toUpperCase()+s.slice(1)}`;
            this._queueCallback((() => {
                this._isTransitioning = !1, this._element.classList.remove(gt), this._element.classList.add(ut, dt), this._element.style[s] = "", $.trigger(this._element, "shown.bs.collapse")
            }), this._element, !0), this._element.style[s] = `${this._element[n]}px`
        }

        hide() {
            if (this._isTransitioning || !this._isShown()) return;
            if ($.trigger(this._element, "hide.bs.collapse").defaultPrevented) return;
            const t = this._getDimension();
            this._element.style[t] = `${this._element.getBoundingClientRect()[t]}px`, f(this._element), this._element.classList.add(gt), this._element.classList.remove(ut, dt);
            const e = this._triggerArray.length;
            for (let t = 0; t < e; t++) {
                const e = this._triggerArray[t], i = r(e);
                i && !this._isShown(i) && this._addAriaAndCollapsedClass([e], !1)
            }
            this._isTransitioning = !0, this._element.style[t] = "", this._queueCallback((() => {
                this._isTransitioning = !1, this._element.classList.remove(gt), this._element.classList.add(ut), $.trigger(this._element, "hidden.bs.collapse")
            }), this._element, !0)
        }

        _isShown(t = this._element) {
            return t.classList.contains(dt)
        }

        _getConfig(t) {
            return (t = {...ct, ...X.getDataAttributes(this._element), ...t}).toggle = Boolean(t.toggle), t.parent = c(t.parent), h(lt, t, ht), t
        }

        _getDimension() {
            return this._element.classList.contains("collapse-horizontal") ? "width" : "height"
        }

        _initializeChildren() {
            if (!this._config.parent) return;
            const t = Y.find(ft, this._config.parent);
            Y.find(pt, this._config.parent).filter((e => !t.includes(e))).forEach((t => {
                const e = r(t);
                e && this._addAriaAndCollapsedClass([t], this._isShown(e))
            }))
        }

        _addAriaAndCollapsedClass(t, e) {
            t.length && t.forEach((t => {
                e ? t.classList.remove(_t) : t.classList.add(_t), t.setAttribute("aria-expanded", e)
            }))
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = {};
                "string" == typeof t && /show|hide/.test(t) && (e.toggle = !1);
                const i = mt.getOrCreateInstance(this, e);
                if ("string" == typeof t) {
                    if (void 0 === i[t]) throw new TypeError(`No method named "${t}"`);
                    i[t]()
                }
            }))
        }
    }

    $.on(document, "click.bs.collapse.data-api", pt, (function (t) {
        ("A" === t.target.tagName || t.delegateTarget && "A" === t.delegateTarget.tagName) && t.preventDefault();
        const e = o(this);
        Y.find(e).forEach((t => {
            mt.getOrCreateInstance(t, {toggle: !1}).toggle()
        }))
    })), v(mt);
    const bt = "dropdown", vt = "Escape", yt = "Space", Et = "ArrowUp", wt = "ArrowDown",
        At = new RegExp("ArrowUp|ArrowDown|Escape"), Tt = "click.bs.dropdown.data-api",
        Ct = "keydown.bs.dropdown.data-api", kt = "show", Lt = '[data-bs-toggle="dropdown"]', St = ".dropdown-menu",
        Ot = b() ? "top-end" : "top-start", Nt = b() ? "top-start" : "top-end",
        Dt = b() ? "bottom-end" : "bottom-start", It = b() ? "bottom-start" : "bottom-end",
        Pt = b() ? "left-start" : "right-start", xt = b() ? "right-start" : "left-start", Mt = {
            offset: [0, 2],
            boundary: "clippingParents",
            reference: "toggle",
            display: "dynamic",
            popperConfig: null,
            autoClose: !0
        }, jt = {
            offset: "(array|string|function)",
            boundary: "(string|element)",
            reference: "(string|element|object)",
            display: "string",
            popperConfig: "(null|object|function)",
            autoClose: "(boolean|string)"
        };

    class Ht extends R {
        constructor(t, e) {
            super(t), this._popper = null, this._config = this._getConfig(e), this._menu = this._getMenuElement(), this._inNavbar = this._detectNavbar()
        }

        static get Default() {
            return Mt
        }

        static get DefaultType() {
            return jt
        }

        static get NAME() {
            return bt
        }

        toggle() {
            return this._isShown() ? this.hide() : this.show()
        }

        show() {
            if (u(this._element) || this._isShown(this._menu)) return;
            const t = {relatedTarget: this._element};
            if ($.trigger(this._element, "show.bs.dropdown", t).defaultPrevented) return;
            const e = Ht.getParentFromElement(this._element);
            this._inNavbar ? X.setDataAttribute(this._menu, "popper", "none") : this._createPopper(e), "ontouchstart" in document.documentElement && !e.closest(".navbar-nav") && [].concat(...document.body.children).forEach((t => $.on(t, "mouseover", _))), this._element.focus(), this._element.setAttribute("aria-expanded", !0), this._menu.classList.add(kt), this._element.classList.add(kt), $.trigger(this._element, "shown.bs.dropdown", t)
        }

        hide() {
            if (u(this._element) || !this._isShown(this._menu)) return;
            const t = {relatedTarget: this._element};
            this._completeHide(t)
        }

        dispose() {
            this._popper && this._popper.destroy(), super.dispose()
        }

        update() {
            this._inNavbar = this._detectNavbar(), this._popper && this._popper.update()
        }

        _completeHide(t) {
            $.trigger(this._element, "hide.bs.dropdown", t).defaultPrevented || ("ontouchstart" in document.documentElement && [].concat(...document.body.children).forEach((t => $.off(t, "mouseover", _))), this._popper && this._popper.destroy(), this._menu.classList.remove(kt), this._element.classList.remove(kt), this._element.setAttribute("aria-expanded", "false"), X.removeDataAttribute(this._menu, "popper"), $.trigger(this._element, "hidden.bs.dropdown", t))
        }

        _getConfig(t) {
            if (t = {...this.constructor.Default, ...X.getDataAttributes(this._element), ...t}, h(bt, t, this.constructor.DefaultType), "object" == typeof t.reference && !l(t.reference) && "function" != typeof t.reference.getBoundingClientRect) throw new TypeError(`${bt.toUpperCase()}: Option "reference" provided type "object" without a required "getBoundingClientRect" method.`);
            return t
        }

        _createPopper(t) {
            if (void 0 === i) throw new TypeError("Bootstrap's dropdowns require Popper (https://popper.js.org)");
            let e = this._element;
            "parent" === this._config.reference ? e = t : l(this._config.reference) ? e = c(this._config.reference) : "object" == typeof this._config.reference && (e = this._config.reference);
            const s = this._getPopperConfig(),
                n = s.modifiers.find((t => "applyStyles" === t.name && !1 === t.enabled));
            this._popper = i.createPopper(e, this._menu, s), n && X.setDataAttribute(this._menu, "popper", "static")
        }

        _isShown(t = this._element) {
            return t.classList.contains(kt)
        }

        _getMenuElement() {
            return Y.next(this._element, St)[0]
        }

        _getPlacement() {
            const t = this._element.parentNode;
            if (t.classList.contains("dropend")) return Pt;
            if (t.classList.contains("dropstart")) return xt;
            const e = "end" === getComputedStyle(this._menu).getPropertyValue("--bs-position").trim();
            return t.classList.contains("dropup") ? e ? Nt : Ot : e ? It : Dt
        }

        _detectNavbar() {
            return null !== this._element.closest(".navbar")
        }

        _getOffset() {
            const {offset: t} = this._config;
            return "string" == typeof t ? t.split(",").map((t => Number.parseInt(t, 10))) : "function" == typeof t ? e => t(e, this._element) : t
        }

        _getPopperConfig() {
            const t = {
                placement: this._getPlacement(),
                modifiers: [{name: "preventOverflow", options: {boundary: this._config.boundary}}, {
                    name: "offset",
                    options: {offset: this._getOffset()}
                }]
            };
            return "static" === this._config.display && (t.modifiers = [{
                name: "applyStyles",
                enabled: !1
            }]), {...t, ..."function" == typeof this._config.popperConfig ? this._config.popperConfig(t) : this._config.popperConfig}
        }

        _selectMenuItem({key: t, target: e}) {
            const i = Y.find(".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)", this._menu).filter(d);
            i.length && w(i, e, t === wt, !i.includes(e)).focus()
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = Ht.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }

        static clearMenus(t) {
            if (t && (2 === t.button || "keyup" === t.type && "Tab" !== t.key)) return;
            const e = Y.find(Lt);
            for (let i = 0, s = e.length; i < s; i++) {
                const s = Ht.getInstance(e[i]);
                if (!s || !1 === s._config.autoClose) continue;
                if (!s._isShown()) continue;
                const n = {relatedTarget: s._element};
                if (t) {
                    const e = t.composedPath(), i = e.includes(s._menu);
                    if (e.includes(s._element) || "inside" === s._config.autoClose && !i || "outside" === s._config.autoClose && i) continue;
                    if (s._menu.contains(t.target) && ("keyup" === t.type && "Tab" === t.key || /input|select|option|textarea|form/i.test(t.target.tagName))) continue;
                    "click" === t.type && (n.clickEvent = t)
                }
                s._completeHide(n)
            }
        }

        static getParentFromElement(t) {
            return r(t) || t.parentNode
        }

        static dataApiKeydownHandler(t) {
            if (/input|textarea/i.test(t.target.tagName) ? t.key === yt || t.key !== vt && (t.key !== wt && t.key !== Et || t.target.closest(St)) : !At.test(t.key)) return;
            const e = this.classList.contains(kt);
            if (!e && t.key === vt) return;
            if (t.preventDefault(), t.stopPropagation(), u(this)) return;
            const i = this.matches(Lt) ? this : Y.prev(this, Lt)[0], s = Ht.getOrCreateInstance(i);
            if (t.key !== vt) return t.key === Et || t.key === wt ? (e || s.show(), void s._selectMenuItem(t)) : void (e && t.key !== yt || Ht.clearMenus());
            s.hide()
        }
    }

    $.on(document, Ct, Lt, Ht.dataApiKeydownHandler), $.on(document, Ct, St, Ht.dataApiKeydownHandler), $.on(document, Tt, Ht.clearMenus), $.on(document, "keyup.bs.dropdown.data-api", Ht.clearMenus), $.on(document, Tt, Lt, (function (t) {
        t.preventDefault(), Ht.getOrCreateInstance(this).toggle()
    })), v(Ht);
    const $t = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top", Bt = ".sticky-top";

    class zt {
        constructor() {
            this._element = document.body
        }

        getWidth() {
            const t = document.documentElement.clientWidth;
            return Math.abs(window.innerWidth-t)
        }

        hide() {
            const t = this.getWidth();
            this._disableOverFlow(), this._setElementAttributes(this._element, "paddingRight", (e => e+t)), this._setElementAttributes($t, "paddingRight", (e => e+t)), this._setElementAttributes(Bt, "marginRight", (e => e-t))
        }

        _disableOverFlow() {
            this._saveInitialAttribute(this._element, "overflow"), this._element.style.overflow = "hidden"
        }

        _setElementAttributes(t, e, i) {
            const s = this.getWidth();
            this._applyManipulationCallback(t, (t => {
                if (t !== this._element && window.innerWidth > t.clientWidth+s) return;
                this._saveInitialAttribute(t, e);
                const n = window.getComputedStyle(t)[e];
                t.style[e] = `${i(Number.parseFloat(n))}px`
            }))
        }

        reset() {
            this._resetElementAttributes(this._element, "overflow"), this._resetElementAttributes(this._element, "paddingRight"), this._resetElementAttributes($t, "paddingRight"), this._resetElementAttributes(Bt, "marginRight")
        }

        _saveInitialAttribute(t, e) {
            const i = t.style[e];
            i && X.setDataAttribute(t, e, i)
        }

        _resetElementAttributes(t, e) {
            this._applyManipulationCallback(t, (t => {
                const i = X.getDataAttribute(t, e);
                void 0 === i ? t.style.removeProperty(e) : (X.removeDataAttribute(t, e), t.style[e] = i)
            }))
        }

        _applyManipulationCallback(t, e) {
            l(t) ? e(t) : Y.find(t, this._element).forEach(e)
        }

        isOverflowing() {
            return this.getWidth() > 0
        }
    }

    const Rt = {className: "modal-backdrop", isVisible: !0, isAnimated: !1, rootElement: "body", clickCallback: null},
        Ft = {
            className: "string",
            isVisible: "boolean",
            isAnimated: "boolean",
            rootElement: "(element|string)",
            clickCallback: "(function|null)"
        }, qt = "show", Wt = "mousedown.bs.backdrop";

    class Ut {
        constructor(t) {
            this._config = this._getConfig(t), this._isAppended = !1, this._element = null
        }

        show(t) {
            this._config.isVisible ? (this._append(), this._config.isAnimated && f(this._getElement()), this._getElement().classList.add(qt), this._emulateAnimation((() => {
                y(t)
            }))) : y(t)
        }

        hide(t) {
            this._config.isVisible ? (this._getElement().classList.remove(qt), this._emulateAnimation((() => {
                this.dispose(), y(t)
            }))) : y(t)
        }

        _getElement() {
            if (!this._element) {
                const t = document.createElement("div");
                t.className = this._config.className, this._config.isAnimated && t.classList.add("fade"), this._element = t
            }
            return this._element
        }

        _getConfig(t) {
            return (t = {...Rt, ..."object" == typeof t ? t : {}}).rootElement = c(t.rootElement), h("backdrop", t, Ft), t
        }

        _append() {
            this._isAppended || (this._config.rootElement.append(this._getElement()), $.on(this._getElement(), Wt, (() => {
                y(this._config.clickCallback)
            })), this._isAppended = !0)
        }

        dispose() {
            this._isAppended && ($.off(this._element, Wt), this._element.remove(), this._isAppended = !1)
        }

        _emulateAnimation(t) {
            E(t, this._getElement(), this._config.isAnimated)
        }
    }

    const Kt = {trapElement: null, autofocus: !0}, Vt = {trapElement: "element", autofocus: "boolean"},
        Xt = ".bs.focustrap", Yt = "backward";

    class Qt {
        constructor(t) {
            this._config = this._getConfig(t), this._isActive = !1, this._lastTabNavDirection = null
        }

        activate() {
            const {trapElement: t, autofocus: e} = this._config;
            this._isActive || (e && t.focus(), $.off(document, Xt), $.on(document, "focusin.bs.focustrap", (t => this._handleFocusin(t))), $.on(document, "keydown.tab.bs.focustrap", (t => this._handleKeydown(t))), this._isActive = !0)
        }

        deactivate() {
            this._isActive && (this._isActive = !1, $.off(document, Xt))
        }

        _handleFocusin(t) {
            const {target: e} = t, {trapElement: i} = this._config;
            if (e === document || e === i || i.contains(e)) return;
            const s = Y.focusableChildren(i);
            0 === s.length ? i.focus() : this._lastTabNavDirection === Yt ? s[s.length-1].focus() : s[0].focus()
        }

        _handleKeydown(t) {
            "Tab" === t.key && (this._lastTabNavDirection = t.shiftKey ? Yt : "forward")
        }

        _getConfig(t) {
            return t = {...Kt, ..."object" == typeof t ? t : {}}, h("focustrap", t, Vt), t
        }
    }

    const Gt = "modal", Zt = "Escape", Jt = {backdrop: !0, keyboard: !0, focus: !0},
        te = {backdrop: "(boolean|string)", keyboard: "boolean", focus: "boolean"}, ee = "hidden.bs.modal",
        ie = "show.bs.modal", se = "resize.bs.modal", ne = "click.dismiss.bs.modal", oe = "keydown.dismiss.bs.modal",
        re = "mousedown.dismiss.bs.modal", ae = "modal-open", le = "show", ce = "modal-static";

    class he extends R {
        constructor(t, e) {
            super(t), this._config = this._getConfig(e), this._dialog = Y.findOne(".modal-dialog", this._element), this._backdrop = this._initializeBackDrop(), this._focustrap = this._initializeFocusTrap(), this._isShown = !1, this._ignoreBackdropClick = !1, this._isTransitioning = !1, this._scrollBar = new zt
        }

        static get Default() {
            return Jt
        }

        static get NAME() {
            return Gt
        }

        toggle(t) {
            return this._isShown ? this.hide() : this.show(t)
        }

        show(t) {
            this._isShown || this._isTransitioning || $.trigger(this._element, ie, {relatedTarget: t}).defaultPrevented || (this._isShown = !0, this._isAnimated() && (this._isTransitioning = !0), this._scrollBar.hide(), document.body.classList.add(ae), this._adjustDialog(), this._setEscapeEvent(), this._setResizeEvent(), $.on(this._dialog, re, (() => {
                $.one(this._element, "mouseup.dismiss.bs.modal", (t => {
                    t.target === this._element && (this._ignoreBackdropClick = !0)
                }))
            })), this._showBackdrop((() => this._showElement(t))))
        }

        hide() {
            if (!this._isShown || this._isTransitioning) return;
            if ($.trigger(this._element, "hide.bs.modal").defaultPrevented) return;
            this._isShown = !1;
            const t = this._isAnimated();
            t && (this._isTransitioning = !0), this._setEscapeEvent(), this._setResizeEvent(), this._focustrap.deactivate(), this._element.classList.remove(le), $.off(this._element, ne), $.off(this._dialog, re), this._queueCallback((() => this._hideModal()), this._element, t)
        }

        dispose() {
            [window, this._dialog].forEach((t => $.off(t, ".bs.modal"))), this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose()
        }

        handleUpdate() {
            this._adjustDialog()
        }

        _initializeBackDrop() {
            return new Ut({isVisible: Boolean(this._config.backdrop), isAnimated: this._isAnimated()})
        }

        _initializeFocusTrap() {
            return new Qt({trapElement: this._element})
        }

        _getConfig(t) {
            return t = {...Jt, ...X.getDataAttributes(this._element), ..."object" == typeof t ? t : {}}, h(Gt, t, te), t
        }

        _showElement(t) {
            const e = this._isAnimated(), i = Y.findOne(".modal-body", this._dialog);
            this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE || document.body.append(this._element), this._element.style.display = "block", this._element.removeAttribute("aria-hidden"), this._element.setAttribute("aria-modal", !0), this._element.setAttribute("role", "dialog"), this._element.scrollTop = 0, i && (i.scrollTop = 0), e && f(this._element), this._element.classList.add(le), this._queueCallback((() => {
                this._config.focus && this._focustrap.activate(), this._isTransitioning = !1, $.trigger(this._element, "shown.bs.modal", {relatedTarget: t})
            }), this._dialog, e)
        }

        _setEscapeEvent() {
            this._isShown ? $.on(this._element, oe, (t => {
                this._config.keyboard && t.key === Zt ? (t.preventDefault(), this.hide()) : this._config.keyboard || t.key !== Zt || this._triggerBackdropTransition()
            })) : $.off(this._element, oe)
        }

        _setResizeEvent() {
            this._isShown ? $.on(window, se, (() => this._adjustDialog())) : $.off(window, se)
        }

        _hideModal() {
            this._element.style.display = "none", this._element.setAttribute("aria-hidden", !0), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._isTransitioning = !1, this._backdrop.hide((() => {
                document.body.classList.remove(ae), this._resetAdjustments(), this._scrollBar.reset(), $.trigger(this._element, ee)
            }))
        }

        _showBackdrop(t) {
            $.on(this._element, ne, (t => {
                this._ignoreBackdropClick ? this._ignoreBackdropClick = !1 : t.target === t.currentTarget && (!0 === this._config.backdrop ? this.hide() : "static" === this._config.backdrop && this._triggerBackdropTransition())
            })), this._backdrop.show(t)
        }

        _isAnimated() {
            return this._element.classList.contains("fade")
        }

        _triggerBackdropTransition() {
            if ($.trigger(this._element, "hidePrevented.bs.modal").defaultPrevented) return;
            const {classList: t, scrollHeight: e, style: i} = this._element,
                s = e > document.documentElement.clientHeight;
            !s && "hidden" === i.overflowY || t.contains(ce) || (s || (i.overflowY = "hidden"), t.add(ce), this._queueCallback((() => {
                t.remove(ce), s || this._queueCallback((() => {
                    i.overflowY = ""
                }), this._dialog)
            }), this._dialog), this._element.focus())
        }

        _adjustDialog() {
            const t = this._element.scrollHeight > document.documentElement.clientHeight,
                e = this._scrollBar.getWidth(), i = e > 0;
            (!i && t && !b() || i && !t && b()) && (this._element.style.paddingLeft = `${e}px`), (i && !t && !b() || !i && t && b()) && (this._element.style.paddingRight = `${e}px`)
        }

        _resetAdjustments() {
            this._element.style.paddingLeft = "", this._element.style.paddingRight = ""
        }

        static jQueryInterface(t, e) {
            return this.each((function () {
                const i = he.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === i[t]) throw new TypeError(`No method named "${t}"`);
                    i[t](e)
                }
            }))
        }
    }

    $.on(document, "click.bs.modal.data-api", '[data-bs-toggle="modal"]', (function (t) {
        const e = r(this);
        ["A", "AREA"].includes(this.tagName) && t.preventDefault(), $.one(e, ie, (t => {
            t.defaultPrevented || $.one(e, ee, (() => {
                d(this) && this.focus()
            }))
        }));
        const i = Y.findOne(".modal.show");
        i && he.getInstance(i).hide(), he.getOrCreateInstance(e).toggle(this)
    })), F(he), v(he);
    const de = "offcanvas", ue = {backdrop: !0, keyboard: !0, scroll: !1},
        ge = {backdrop: "boolean", keyboard: "boolean", scroll: "boolean"}, _e = "show", fe = ".offcanvas.show",
        pe = "hidden.bs.offcanvas";

    class me extends R {
        constructor(t, e) {
            super(t), this._config = this._getConfig(e), this._isShown = !1, this._backdrop = this._initializeBackDrop(), this._focustrap = this._initializeFocusTrap(), this._addEventListeners()
        }

        static get NAME() {
            return de
        }

        static get Default() {
            return ue
        }

        toggle(t) {
            return this._isShown ? this.hide() : this.show(t)
        }

        show(t) {
            this._isShown || $.trigger(this._element, "show.bs.offcanvas", {relatedTarget: t}).defaultPrevented || (this._isShown = !0, this._element.style.visibility = "visible", this._backdrop.show(), this._config.scroll || (new zt).hide(), this._element.removeAttribute("aria-hidden"), this._element.setAttribute("aria-modal", !0), this._element.setAttribute("role", "dialog"), this._element.classList.add(_e), this._queueCallback((() => {
                this._config.scroll || this._focustrap.activate(), $.trigger(this._element, "shown.bs.offcanvas", {relatedTarget: t})
            }), this._element, !0))
        }

        hide() {
            this._isShown && ($.trigger(this._element, "hide.bs.offcanvas").defaultPrevented || (this._focustrap.deactivate(), this._element.blur(), this._isShown = !1, this._element.classList.remove(_e), this._backdrop.hide(), this._queueCallback((() => {
                this._element.setAttribute("aria-hidden", !0), this._element.removeAttribute("aria-modal"), this._element.removeAttribute("role"), this._element.style.visibility = "hidden", this._config.scroll || (new zt).reset(), $.trigger(this._element, pe)
            }), this._element, !0)))
        }

        dispose() {
            this._backdrop.dispose(), this._focustrap.deactivate(), super.dispose()
        }

        _getConfig(t) {
            return t = {...ue, ...X.getDataAttributes(this._element), ..."object" == typeof t ? t : {}}, h(de, t, ge), t
        }

        _initializeBackDrop() {
            return new Ut({
                className: "offcanvas-backdrop",
                isVisible: this._config.backdrop,
                isAnimated: !0,
                rootElement: this._element.parentNode,
                clickCallback: () => this.hide()
            })
        }

        _initializeFocusTrap() {
            return new Qt({trapElement: this._element})
        }

        _addEventListeners() {
            $.on(this._element, "keydown.dismiss.bs.offcanvas", (t => {
                this._config.keyboard && "Escape" === t.key && this.hide()
            }))
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = me.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t] || t.startsWith("_") || "constructor" === t) throw new TypeError(`No method named "${t}"`);
                    e[t](this)
                }
            }))
        }
    }

    $.on(document, "click.bs.offcanvas.data-api", '[data-bs-toggle="offcanvas"]', (function (t) {
        const e = r(this);
        if (["A", "AREA"].includes(this.tagName) && t.preventDefault(), u(this)) return;
        $.one(e, pe, (() => {
            d(this) && this.focus()
        }));
        const i = Y.findOne(fe);
        i && i !== e && me.getInstance(i).hide(), me.getOrCreateInstance(e).toggle(this)
    })), $.on(window, "load.bs.offcanvas.data-api", (() => Y.find(fe).forEach((t => me.getOrCreateInstance(t).show())))), F(me), v(me);
    const be = new Set(["background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href"]),
        ve = /^(?:(?:https?|mailto|ftp|tel|file|sms):|[^#&/:?]*(?:[#/?]|$))/i,
        ye = /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+/a-z]+=*$/i,
        Ee = (t, e) => {
            const i = t.nodeName.toLowerCase();
            if (e.includes(i)) return !be.has(i) || Boolean(ve.test(t.nodeValue) || ye.test(t.nodeValue));
            const s = e.filter((t => t instanceof RegExp));
            for (let t = 0, e = s.length; t < e; t++) if (s[t].test(i)) return !0;
            return !1
        };

    function we(t, e, i) {
        if (!t.length) return t;
        if (i && "function" == typeof i) return i(t);
        const s = (new window.DOMParser).parseFromString(t, "text/html"),
            n = [].concat(...s.body.querySelectorAll("*"));
        for (let t = 0, i = n.length; t < i; t++) {
            const i = n[t], s = i.nodeName.toLowerCase();
            if (!Object.keys(e).includes(s)) {
                i.remove();
                continue
            }
            const o = [].concat(...i.attributes), r = [].concat(e["*"] || [], e[s] || []);
            o.forEach((t => {
                Ee(t, r) || i.removeAttribute(t.nodeName)
            }))
        }
        return s.body.innerHTML
    }

    const Ae = "tooltip", Te = new Set(["sanitize", "allowList", "sanitizeFn"]), Ce = {
            animation: "boolean",
            template: "string",
            title: "(string|element|function)",
            trigger: "string",
            delay: "(number|object)",
            html: "boolean",
            selector: "(string|boolean)",
            placement: "(string|function)",
            offset: "(array|string|function)",
            container: "(string|element|boolean)",
            fallbackPlacements: "array",
            boundary: "(string|element)",
            customClass: "(string|function)",
            sanitize: "boolean",
            sanitizeFn: "(null|function)",
            allowList: "object",
            popperConfig: "(null|object|function)"
        }, ke = {AUTO: "auto", TOP: "top", RIGHT: b() ? "left" : "right", BOTTOM: "bottom", LEFT: b() ? "right" : "left"},
        Le = {
            animation: !0,
            template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
            trigger: "hover focus",
            title: "",
            delay: 0,
            html: !1,
            selector: !1,
            placement: "top",
            offset: [0, 0],
            container: !1,
            fallbackPlacements: ["top", "right", "bottom", "left"],
            boundary: "clippingParents",
            customClass: "",
            sanitize: !0,
            sanitizeFn: null,
            allowList: {
                "*": ["class", "dir", "id", "lang", "role", /^aria-[\w-]*$/i],
                a: ["target", "href", "title", "rel"],
                area: [],
                b: [],
                br: [],
                col: [],
                code: [],
                div: [],
                em: [],
                hr: [],
                h1: [],
                h2: [],
                h3: [],
                h4: [],
                h5: [],
                h6: [],
                i: [],
                img: ["src", "srcset", "alt", "title", "width", "height"],
                li: [],
                ol: [],
                p: [],
                pre: [],
                s: [],
                small: [],
                span: [],
                sub: [],
                sup: [],
                strong: [],
                u: [],
                ul: []
            },
            popperConfig: null
        }, Se = {
            HIDE: "hide.bs.tooltip",
            HIDDEN: "hidden.bs.tooltip",
            SHOW: "show.bs.tooltip",
            SHOWN: "shown.bs.tooltip",
            INSERTED: "inserted.bs.tooltip",
            CLICK: "click.bs.tooltip",
            FOCUSIN: "focusin.bs.tooltip",
            FOCUSOUT: "focusout.bs.tooltip",
            MOUSEENTER: "mouseenter.bs.tooltip",
            MOUSELEAVE: "mouseleave.bs.tooltip"
        }, Oe = "fade", Ne = "show", De = "show", Ie = "out", Pe = ".tooltip-inner", xe = ".modal", Me = "hide.bs.modal",
        je = "hover", He = "focus";

    class $e extends R {
        constructor(t, e) {
            if (void 0 === i) throw new TypeError("Bootstrap's tooltips require Popper (https://popper.js.org)");
            super(t), this._isEnabled = !0, this._timeout = 0, this._hoverState = "", this._activeTrigger = {}, this._popper = null, this._config = this._getConfig(e), this.tip = null, this._setListeners()
        }

        static get Default() {
            return Le
        }

        static get NAME() {
            return Ae
        }

        static get Event() {
            return Se
        }

        static get DefaultType() {
            return Ce
        }

        enable() {
            this._isEnabled = !0
        }

        disable() {
            this._isEnabled = !1
        }

        toggleEnabled() {
            this._isEnabled = !this._isEnabled
        }

        toggle(t) {
            if (this._isEnabled) if (t) {
                const e = this._initializeOnDelegatedTarget(t);
                e._activeTrigger.click = !e._activeTrigger.click, e._isWithActiveTrigger() ? e._enter(null, e) : e._leave(null, e)
            } else {
                if (this.getTipElement().classList.contains(Ne)) return void this._leave(null, this);
                this._enter(null, this)
            }
        }

        dispose() {
            clearTimeout(this._timeout), $.off(this._element.closest(xe), Me, this._hideModalHandler), this.tip && this.tip.remove(), this._disposePopper(), super.dispose()
        }

        show() {
            if ("none" === this._element.style.display) throw new Error("Please use show on visible elements");
            if (!this.isWithContent() || !this._isEnabled) return;
            const t = $.trigger(this._element, this.constructor.Event.SHOW), e = g(this._element),
                s = null === e ? this._element.ownerDocument.documentElement.contains(this._element) : e.contains(this._element);
            if (t.defaultPrevented || !s) return;
            "tooltip" === this.constructor.NAME && this.tip && this.getTitle() !== this.tip.querySelector(Pe).innerHTML && (this._disposePopper(), this.tip.remove(), this.tip = null);
            const n = this.getTipElement(), o = (t => {
                do {
                    t += Math.floor(1e6 * Math.random())
                } while (document.getElementById(t));
                return t
            })(this.constructor.NAME);
            n.setAttribute("id", o), this._element.setAttribute("aria-describedby", o), this._config.animation && n.classList.add(Oe);
            const r = "function" == typeof this._config.placement ? this._config.placement.call(this, n, this._element) : this._config.placement,
                a = this._getAttachment(r);
            this._addAttachmentClass(a);
            const {container: l} = this._config;
            z.set(n, this.constructor.DATA_KEY, this), this._element.ownerDocument.documentElement.contains(this.tip) || (l.append(n), $.trigger(this._element, this.constructor.Event.INSERTED)), this._popper ? this._popper.update() : this._popper = i.createPopper(this._element, n, this._getPopperConfig(a)), n.classList.add(Ne);
            const c = this._resolvePossibleFunction(this._config.customClass);
            c && n.classList.add(...c.split(" ")), "ontouchstart" in document.documentElement && [].concat(...document.body.children).forEach((t => {
                $.on(t, "mouseover", _)
            }));
            const h = this.tip.classList.contains(Oe);
            this._queueCallback((() => {
                const t = this._hoverState;
                this._hoverState = null, $.trigger(this._element, this.constructor.Event.SHOWN), t === Ie && this._leave(null, this)
            }), this.tip, h)
        }

        hide() {
            if (!this._popper) return;
            const t = this.getTipElement();
            if ($.trigger(this._element, this.constructor.Event.HIDE).defaultPrevented) return;
            t.classList.remove(Ne), "ontouchstart" in document.documentElement && [].concat(...document.body.children).forEach((t => $.off(t, "mouseover", _))), this._activeTrigger.click = !1, this._activeTrigger.focus = !1, this._activeTrigger.hover = !1;
            const e = this.tip.classList.contains(Oe);
            this._queueCallback((() => {
                this._isWithActiveTrigger() || (this._hoverState !== De && t.remove(), this._cleanTipClass(), this._element.removeAttribute("aria-describedby"), $.trigger(this._element, this.constructor.Event.HIDDEN), this._disposePopper())
            }), this.tip, e), this._hoverState = ""
        }

        update() {
            null !== this._popper && this._popper.update()
        }

        isWithContent() {
            return Boolean(this.getTitle())
        }

        getTipElement() {
            if (this.tip) return this.tip;
            const t = document.createElement("div");
            t.innerHTML = this._config.template;
            const e = t.children[0];
            return this.setContent(e), e.classList.remove(Oe, Ne), this.tip = e, this.tip
        }

        setContent(t) {
            this._sanitizeAndSetContent(t, this.getTitle(), Pe)
        }

        _sanitizeAndSetContent(t, e, i) {
            const s = Y.findOne(i, t);
            e || !s ? this.setElementContent(s, e) : s.remove()
        }

        setElementContent(t, e) {
            if (null !== t) return l(e) ? (e = c(e), void (this._config.html ? e.parentNode !== t && (t.innerHTML = "", t.append(e)) : t.textContent = e.textContent)) : void (this._config.html ? (this._config.sanitize && (e = we(e, this._config.allowList, this._config.sanitizeFn)), t.innerHTML = e) : t.textContent = e)
        }

        getTitle() {
            const t = this._element.getAttribute("data-bs-original-title") || this._config.title;
            return this._resolvePossibleFunction(t)
        }

        updateAttachment(t) {
            return "right" === t ? "end" : "left" === t ? "start" : t
        }

        _initializeOnDelegatedTarget(t, e) {
            return e || this.constructor.getOrCreateInstance(t.delegateTarget, this._getDelegateConfig())
        }

        _getOffset() {
            const {offset: t} = this._config;
            return "string" == typeof t ? t.split(",").map((t => Number.parseInt(t, 10))) : "function" == typeof t ? e => t(e, this._element) : t
        }

        _resolvePossibleFunction(t) {
            return "function" == typeof t ? t.call(this._element) : t
        }

        _getPopperConfig(t) {
            const e = {
                placement: t,
                modifiers: [{
                    name: "flip",
                    options: {fallbackPlacements: this._config.fallbackPlacements}
                }, {name: "offset", options: {offset: this._getOffset()}}, {
                    name: "preventOverflow",
                    options: {boundary: this._config.boundary}
                }, {name: "arrow", options: {element: `.${this.constructor.NAME}-arrow`}}, {
                    name: "onChange",
                    enabled: !0,
                    phase: "afterWrite",
                    fn: t => this._handlePopperPlacementChange(t)
                }],
                onFirstUpdate: t => {
                    t.options.placement !== t.placement && this._handlePopperPlacementChange(t)
                }
            };
            return {...e, ..."function" == typeof this._config.popperConfig ? this._config.popperConfig(e) : this._config.popperConfig}
        }

        _addAttachmentClass(t) {
            this.getTipElement().classList.add(`${this._getBasicClassPrefix()}-${this.updateAttachment(t)}`)
        }

        _getAttachment(t) {
            return ke[t.toUpperCase()]
        }

        _setListeners() {
            this._config.trigger.split(" ").forEach((t => {
                if ("click" === t) $.on(this._element, this.constructor.Event.CLICK, this._config.selector, (t => this.toggle(t))); else if ("manual" !== t) {
                    const e = t === je ? this.constructor.Event.MOUSEENTER : this.constructor.Event.FOCUSIN,
                        i = t === je ? this.constructor.Event.MOUSELEAVE : this.constructor.Event.FOCUSOUT;
                    $.on(this._element, e, this._config.selector, (t => this._enter(t))), $.on(this._element, i, this._config.selector, (t => this._leave(t)))
                }
            })), this._hideModalHandler = () => {
                this._element && this.hide()
            }, $.on(this._element.closest(xe), Me, this._hideModalHandler), this._config.selector ? this._config = {
                ...this._config,
                trigger: "manual",
                selector: ""
            } : this._fixTitle()
        }

        _fixTitle() {
            const t = this._element.getAttribute("title"),
                e = typeof this._element.getAttribute("data-bs-original-title");
            (t || "string" !== e) && (this._element.setAttribute("data-bs-original-title", t || ""), !t || this._element.getAttribute("aria-label") || this._element.textContent || this._element.setAttribute("aria-label", t), this._element.setAttribute("title", ""))
        }

        _enter(t, e) {
            e = this._initializeOnDelegatedTarget(t, e), t && (e._activeTrigger["focusin" === t.type ? He : je] = !0), e.getTipElement().classList.contains(Ne) || e._hoverState === De ? e._hoverState = De : (clearTimeout(e._timeout), e._hoverState = De, e._config.delay && e._config.delay.show ? e._timeout = setTimeout((() => {
                e._hoverState === De && e.show()
            }), e._config.delay.show) : e.show())
        }

        _leave(t, e) {
            e = this._initializeOnDelegatedTarget(t, e), t && (e._activeTrigger["focusout" === t.type ? He : je] = e._element.contains(t.relatedTarget)), e._isWithActiveTrigger() || (clearTimeout(e._timeout), e._hoverState = Ie, e._config.delay && e._config.delay.hide ? e._timeout = setTimeout((() => {
                e._hoverState === Ie && e.hide()
            }), e._config.delay.hide) : e.hide())
        }

        _isWithActiveTrigger() {
            for (const t in this._activeTrigger) if (this._activeTrigger[t]) return !0;
            return !1
        }

        _getConfig(t) {
            const e = X.getDataAttributes(this._element);
            return Object.keys(e).forEach((t => {
                Te.has(t) && delete e[t]
            })), (t = {...this.constructor.Default, ...e, ..."object" == typeof t && t ? t : {}}).container = !1 === t.container ? document.body : c(t.container), "number" == typeof t.delay && (t.delay = {
                show: t.delay,
                hide: t.delay
            }), "number" == typeof t.title && (t.title = t.title.toString()), "number" == typeof t.content && (t.content = t.content.toString()), h(Ae, t, this.constructor.DefaultType), t.sanitize && (t.template = we(t.template, t.allowList, t.sanitizeFn)), t
        }

        _getDelegateConfig() {
            const t = {};
            for (const e in this._config) this.constructor.Default[e] !== this._config[e] && (t[e] = this._config[e]);
            return t
        }

        _cleanTipClass() {
            const t = this.getTipElement(), e = new RegExp(`(^|\\s)${this._getBasicClassPrefix()}\\S+`, "g"),
                i = t.getAttribute("class").match(e);
            null !== i && i.length > 0 && i.map((t => t.trim())).forEach((e => t.classList.remove(e)))
        }

        _getBasicClassPrefix() {
            return "bs-tooltip"
        }

        _handlePopperPlacementChange(t) {
            const {state: e} = t;
            e && (this.tip = e.elements.popper, this._cleanTipClass(), this._addAttachmentClass(this._getAttachment(e.placement)))
        }

        _disposePopper() {
            this._popper && (this._popper.destroy(), this._popper = null)
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = $e.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }
    }

    v($e);
    const Be = {
        ...$e.Default,
        placement: "right",
        offset: [0, 8],
        trigger: "click",
        content: "",
        template: '<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
    }, ze = {...$e.DefaultType, content: "(string|element|function)"}, Re = {
        HIDE: "hide.bs.popover",
        HIDDEN: "hidden.bs.popover",
        SHOW: "show.bs.popover",
        SHOWN: "shown.bs.popover",
        INSERTED: "inserted.bs.popover",
        CLICK: "click.bs.popover",
        FOCUSIN: "focusin.bs.popover",
        FOCUSOUT: "focusout.bs.popover",
        MOUSEENTER: "mouseenter.bs.popover",
        MOUSELEAVE: "mouseleave.bs.popover"
    };

    class Fe extends $e {
        static get Default() {
            return Be
        }

        static get NAME() {
            return "popover"
        }

        static get Event() {
            return Re
        }

        static get DefaultType() {
            return ze
        }

        isWithContent() {
            return this.getTitle() || this._getContent()
        }

        setContent(t) {
            this._sanitizeAndSetContent(t, this.getTitle(), ".popover-header"), this._sanitizeAndSetContent(t, this._getContent(), ".popover-body")
        }

        _getContent() {
            return this._resolvePossibleFunction(this._config.content)
        }

        _getBasicClassPrefix() {
            return "bs-popover"
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = Fe.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }
    }

    v(Fe);
    const qe = "scrollspy", We = {offset: 10, method: "auto", target: ""},
        Ue = {offset: "number", method: "string", target: "(string|element)"}, Ke = "active",
        Ve = ".nav-link, .list-group-item, .dropdown-item", Xe = "position";

    class Ye extends R {
        constructor(t, e) {
            super(t), this._scrollElement = "BODY" === this._element.tagName ? window : this._element, this._config = this._getConfig(e), this._offsets = [], this._targets = [], this._activeTarget = null, this._scrollHeight = 0, $.on(this._scrollElement, "scroll.bs.scrollspy", (() => this._process())), this.refresh(), this._process()
        }

        static get Default() {
            return We
        }

        static get NAME() {
            return qe
        }

        refresh() {
            const t = this._scrollElement === this._scrollElement.window ? "offset" : Xe,
                e = "auto" === this._config.method ? t : this._config.method, i = e === Xe ? this._getScrollTop() : 0;
            this._offsets = [], this._targets = [], this._scrollHeight = this._getScrollHeight(), Y.find(Ve, this._config.target).map((t => {
                const s = o(t), n = s ? Y.findOne(s) : null;
                if (n) {
                    const t = n.getBoundingClientRect();
                    if (t.width || t.height) return [X[e](n).top+i, s]
                }
                return null
            })).filter((t => t)).sort(((t, e) => t[0]-e[0])).forEach((t => {
                this._offsets.push(t[0]), this._targets.push(t[1])
            }))
        }

        dispose() {
            $.off(this._scrollElement, ".bs.scrollspy"), super.dispose()
        }

        _getConfig(t) {
            return (t = {...We, ...X.getDataAttributes(this._element), ..."object" == typeof t && t ? t : {}}).target = c(t.target) || document.documentElement, h(qe, t, Ue), t
        }

        _getScrollTop() {
            return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop
        }

        _getScrollHeight() {
            return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight)
        }

        _getOffsetHeight() {
            return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height
        }

        _process() {
            const t = this._getScrollTop()+this._config.offset, e = this._getScrollHeight(),
                i = this._config.offset+e-this._getOffsetHeight();
            if (this._scrollHeight !== e && this.refresh(), t >= i) {
                const t = this._targets[this._targets.length-1];
                this._activeTarget !== t && this._activate(t)
            } else {
                if (this._activeTarget && t < this._offsets[0] && this._offsets[0] > 0) return this._activeTarget = null, void this._clear();
                for (let e = this._offsets.length; e--;) this._activeTarget !== this._targets[e] && t >= this._offsets[e] && (void 0 === this._offsets[e+1] || t < this._offsets[e+1]) && this._activate(this._targets[e])
            }
        }

        _activate(t) {
            this._activeTarget = t, this._clear();
            const e = Ve.split(",").map((e => `${e}[data-bs-target="${t}"],${e}[href="${t}"]`)),
                i = Y.findOne(e.join(","), this._config.target);
            i.classList.add(Ke), i.classList.contains("dropdown-item") ? Y.findOne(".dropdown-toggle", i.closest(".dropdown")).classList.add(Ke) : Y.parents(i, ".nav, .list-group").forEach((t => {
                Y.prev(t, ".nav-link, .list-group-item").forEach((t => t.classList.add(Ke))), Y.prev(t, ".nav-item").forEach((t => {
                    Y.children(t, ".nav-link").forEach((t => t.classList.add(Ke)))
                }))
            })), $.trigger(this._scrollElement, "activate.bs.scrollspy", {relatedTarget: t})
        }

        _clear() {
            Y.find(Ve, this._config.target).filter((t => t.classList.contains(Ke))).forEach((t => t.classList.remove(Ke)))
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = Ye.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }
    }

    $.on(window, "load.bs.scrollspy.data-api", (() => {
        Y.find('[data-bs-spy="scroll"]').forEach((t => new Ye(t)))
    })), v(Ye);
    const Qe = "active", Ge = "fade", Ze = "show", Je = ".active", ti = ":scope > li > .active";

    class ei extends R {
        static get NAME() {
            return "tab"
        }

        show() {
            if (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && this._element.classList.contains(Qe)) return;
            let t;
            const e = r(this._element), i = this._element.closest(".nav, .list-group");
            if (i) {
                const e = "UL" === i.nodeName || "OL" === i.nodeName ? ti : Je;
                t = Y.find(e, i), t = t[t.length-1]
            }
            const s = t ? $.trigger(t, "hide.bs.tab", {relatedTarget: this._element}) : null;
            if ($.trigger(this._element, "show.bs.tab", {relatedTarget: t}).defaultPrevented || null !== s && s.defaultPrevented) return;
            this._activate(this._element, i);
            const n = () => {
                $.trigger(t, "hidden.bs.tab", {relatedTarget: this._element}), $.trigger(this._element, "shown.bs.tab", {relatedTarget: t})
            };
            e ? this._activate(e, e.parentNode, n) : n()
        }

        _activate(t, e, i) {
            const s = (!e || "UL" !== e.nodeName && "OL" !== e.nodeName ? Y.children(e, Je) : Y.find(ti, e))[0],
                n = i && s && s.classList.contains(Ge), o = () => this._transitionComplete(t, s, i);
            s && n ? (s.classList.remove(Ze), this._queueCallback(o, t, !0)) : o()
        }

        _transitionComplete(t, e, i) {
            if (e) {
                e.classList.remove(Qe);
                const t = Y.findOne(":scope > .dropdown-menu .active", e.parentNode);
                t && t.classList.remove(Qe), "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !1)
            }
            t.classList.add(Qe), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !0), f(t), t.classList.contains(Ge) && t.classList.add(Ze);
            let s = t.parentNode;
            if (s && "LI" === s.nodeName && (s = s.parentNode), s && s.classList.contains("dropdown-menu")) {
                const e = t.closest(".dropdown");
                e && Y.find(".dropdown-toggle", e).forEach((t => t.classList.add(Qe))), t.setAttribute("aria-expanded", !0)
            }
            i && i()
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = ei.getOrCreateInstance(this);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t]()
                }
            }))
        }
    }

    $.on(document, "click.bs.tab.data-api", '[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]', (function (t) {
        ["A", "AREA"].includes(this.tagName) && t.preventDefault(), u(this) || ei.getOrCreateInstance(this).show()
    })), v(ei);
    const ii = "toast", si = "hide", ni = "show", oi = "showing",
        ri = {animation: "boolean", autohide: "boolean", delay: "number"},
        ai = {animation: !0, autohide: !0, delay: 5e3};

    class li extends R {
        constructor(t, e) {
            super(t), this._config = this._getConfig(e), this._timeout = null, this._hasMouseInteraction = !1, this._hasKeyboardInteraction = !1, this._setListeners()
        }

        static get DefaultType() {
            return ri
        }

        static get Default() {
            return ai
        }

        static get NAME() {
            return ii
        }

        show() {
            $.trigger(this._element, "show.bs.toast").defaultPrevented || (this._clearTimeout(), this._config.animation && this._element.classList.add("fade"), this._element.classList.remove(si), f(this._element), this._element.classList.add(ni), this._element.classList.add(oi), this._queueCallback((() => {
                this._element.classList.remove(oi), $.trigger(this._element, "shown.bs.toast"), this._maybeScheduleHide()
            }), this._element, this._config.animation))
        }

        hide() {
            this._element.classList.contains(ni) && ($.trigger(this._element, "hide.bs.toast").defaultPrevented || (this._element.classList.add(oi), this._queueCallback((() => {
                this._element.classList.add(si), this._element.classList.remove(oi), this._element.classList.remove(ni), $.trigger(this._element, "hidden.bs.toast")
            }), this._element, this._config.animation)))
        }

        dispose() {
            this._clearTimeout(), this._element.classList.contains(ni) && this._element.classList.remove(ni), super.dispose()
        }

        _getConfig(t) {
            return t = {...ai, ...X.getDataAttributes(this._element), ..."object" == typeof t && t ? t : {}}, h(ii, t, this.constructor.DefaultType), t
        }

        _maybeScheduleHide() {
            this._config.autohide && (this._hasMouseInteraction || this._hasKeyboardInteraction || (this._timeout = setTimeout((() => {
                this.hide()
            }), this._config.delay)))
        }

        _onInteraction(t, e) {
            switch (t.type) {
                case"mouseover":
                case"mouseout":
                    this._hasMouseInteraction = e;
                    break;
                case"focusin":
                case"focusout":
                    this._hasKeyboardInteraction = e
            }
            if (e) return void this._clearTimeout();
            const i = t.relatedTarget;
            this._element === i || this._element.contains(i) || this._maybeScheduleHide()
        }

        _setListeners() {
            $.on(this._element, "mouseover.bs.toast", (t => this._onInteraction(t, !0))), $.on(this._element, "mouseout.bs.toast", (t => this._onInteraction(t, !1))), $.on(this._element, "focusin.bs.toast", (t => this._onInteraction(t, !0))), $.on(this._element, "focusout.bs.toast", (t => this._onInteraction(t, !1)))
        }

        _clearTimeout() {
            clearTimeout(this._timeout), this._timeout = null
        }

        static jQueryInterface(t) {
            return this.each((function () {
                const e = li.getOrCreateInstance(this, t);
                if ("string" == typeof t) {
                    if (void 0 === e[t]) throw new TypeError(`No method named "${t}"`);
                    e[t](this)
                }
            }))
        }
    }

    return F(li), v(li), {
        Alert: q,
        Button: U,
        Carousel: at,
        Collapse: mt,
        Dropdown: Ht,
        Modal: he,
        Offcanvas: me,
        Popover: Fe,
        ScrollSpy: Ye,
        Tab: ei,
        Toast: li,
        Tooltip: $e
    }
}));
//# sourceMappingURL=bootstrap.min.js.map
!function (t, e) {
    "object" == typeof exports && "object" == typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define([], e) : "object" == typeof exports ? exports.swal = e() : t.swal = e()
}(this, function () {
    return function (t) {
        function e(o) {
            if (n[o]) return n[o].exports;
            var r = n[o] = {i: o, l: !1, exports: {}};
            return t[o].call(r.exports, r, r.exports, e), r.l = !0, r.exports
        }

        var n = {};
        return e.m = t, e.c = n, e.d = function (t, n, o) {
            e.o(t, n) || Object.defineProperty(t, n, {configurable: !1, enumerable: !0, get: o})
        }, e.n = function (t) {
            var n = t && t.__esModule ? function () {
                return t.default
            } : function () {
                return t
            };
            return e.d(n, "a", n), n
        }, e.o = function (t, e) {
            return Object.prototype.hasOwnProperty.call(t, e)
        }, e.p = "", e(e.s = 8)
    }([function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = "swal-button";
        e.CLASS_NAMES = {
            MODAL: "swal-modal",
            OVERLAY: "swal-overlay",
            SHOW_MODAL: "swal-overlay--show-modal",
            MODAL_TITLE: "swal-title",
            MODAL_TEXT: "swal-text",
            ICON: "swal-icon",
            ICON_CUSTOM: "swal-icon--custom",
            CONTENT: "swal-content",
            FOOTER: "swal-footer",
            BUTTON_CONTAINER: "swal-button-container",
            BUTTON: o,
            CONFIRM_BUTTON: o+"--confirm",
            CANCEL_BUTTON: o+"--cancel",
            DANGER_BUTTON: o+"--danger",
            BUTTON_LOADING: o+"--loading",
            BUTTON_LOADER: o+"__loader"
        }, e.default = e.CLASS_NAMES
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0}), e.getNode = function (t) {
            var e = "."+t;
            return document.querySelector(e)
        }, e.stringToNode = function (t) {
            var e = document.createElement("div");
            return e.innerHTML = t.trim(), e.firstChild
        }, e.insertAfter = function (t, e) {
            var n = e.nextSibling;
            e.parentNode.insertBefore(t, n)
        }, e.removeNode = function (t) {
            t.parentElement.removeChild(t)
        }, e.throwErr = function (t) {
            throw t = t.replace(/ +(?= )/g, ""), "SweetAlert: "+(t = t.trim())
        }, e.isPlainObject = function (t) {
            if ("[object Object]" !== Object.prototype.toString.call(t)) return !1;
            var e = Object.getPrototypeOf(t);
            return null === e || e === Object.prototype
        }, e.ordinalSuffixOf = function (t) {
            var e = t % 10, n = t % 100;
            return 1 === e && 11 !== n ? t+"st" : 2 === e && 12 !== n ? t+"nd" : 3 === e && 13 !== n ? t+"rd" : t+"th"
        }
    }, function (t, e, n) {
        "use strict";

        function o(t) {
            for (var n in t) e.hasOwnProperty(n) || (e[n] = t[n])
        }

        Object.defineProperty(e, "__esModule", {value: !0}), o(n(25));
        var r = n(26);
        e.overlayMarkup = r.default, o(n(27)), o(n(28)), o(n(29));
        var i = n(0), a = i.default.MODAL_TITLE, s = i.default.MODAL_TEXT, c = i.default.ICON, l = i.default.FOOTER;
        e.iconMarkup = '\n  <div class="'+c+'"></div>', e.titleMarkup = '\n  <div class="'+a+'"></div>\n', e.textMarkup = '\n  <div class="'+s+'"></div>', e.footerMarkup = '\n  <div class="'+l+'"></div>\n'
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(1);
        e.CONFIRM_KEY = "confirm", e.CANCEL_KEY = "cancel";
        var r = {visible: !0, text: null, value: null, className: "", closeModal: !0},
            i = Object.assign({}, r, {visible: !1, text: "Cancel", value: null}),
            a = Object.assign({}, r, {text: "OK", value: !0});
        e.defaultButtonList = {cancel: i, confirm: a};
        var s = function (t) {
            switch (t) {
                case e.CONFIRM_KEY:
                    return a;
                case e.CANCEL_KEY:
                    return i;
                default:
                    var n = t.charAt(0).toUpperCase()+t.slice(1);
                    return Object.assign({}, r, {text: n, value: t})
            }
        }, c = function (t, e) {
            var n = s(t);
            return !0 === e ? Object.assign({}, n, {visible: !0}) : "string" == typeof e ? Object.assign({}, n, {
                visible: !0,
                text: e
            }) : o.isPlainObject(e) ? Object.assign({visible: !0}, n, e) : Object.assign({}, n, {visible: !1})
        }, l = function (t) {
            for (var e = {}, n = 0, o = Object.keys(t); n < o.length; n++) {
                var r = o[n], a = t[r], s = c(r, a);
                e[r] = s
            }
            return e.cancel || (e.cancel = i), e
        }, u = function (t) {
            var n = {};
            switch (t.length) {
                case 1:
                    n[e.CANCEL_KEY] = Object.assign({}, i, {visible: !1});
                    break;
                case 2:
                    n[e.CANCEL_KEY] = c(e.CANCEL_KEY, t[0]), n[e.CONFIRM_KEY] = c(e.CONFIRM_KEY, t[1]);
                    break;
                default:
                    o.throwErr("Invalid number of 'buttons' in array ("+t.length+").\n      If you want more than 2 buttons, you need to use an object!")
            }
            return n
        };
        e.getButtonListOpts = function (t) {
            var n = e.defaultButtonList;
            return "string" == typeof t ? n[e.CONFIRM_KEY] = c(e.CONFIRM_KEY, t) : Array.isArray(t) ? n = u(t) : o.isPlainObject(t) ? n = l(t) : !0 === t ? n = u([!0, !0]) : !1 === t ? n = u([!1, !1]) : void 0 === t && (n = e.defaultButtonList), n
        }
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(1), r = n(2), i = n(0), a = i.default.MODAL, s = i.default.OVERLAY, c = n(30), l = n(31), u = n(32),
            f = n(33);
        e.injectElIntoModal = function (t) {
            var e = o.getNode(a), n = o.stringToNode(t);
            return e.appendChild(n), n
        };
        var d = function (t) {
            t.className = a, t.textContent = ""
        }, p = function (t, e) {
            d(t);
            var n = e.className;
            n && t.classList.add(n)
        };
        e.initModalContent = function (t) {
            var e = o.getNode(a);
            p(e, t), c.default(t.icon), l.initTitle(t.title), l.initText(t.text), f.default(t.content), u.default(t.buttons, t.dangerMode)
        };
        var m = function () {
            var t = o.getNode(s), e = o.stringToNode(r.modalMarkup);
            t.appendChild(e)
        };
        e.default = m
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(3), r = {isOpen: !1, promise: null, actions: {}, timer: null}, i = Object.assign({}, r);
        e.resetState = function () {
            i = Object.assign({}, r)
        }, e.setActionValue = function (t) {
            if ("string" == typeof t) return a(o.CONFIRM_KEY, t);
            for (var e in t) a(e, t[e])
        };
        var a = function (t, e) {
            i.actions[t] || (i.actions[t] = {}), Object.assign(i.actions[t], {value: e})
        };
        e.setActionOptionsFor = function (t, e) {
            var n = (void 0 === e ? {} : e).closeModal, o = void 0 === n || n;
            Object.assign(i.actions[t], {closeModal: o})
        }, e.default = i
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(1), r = n(3), i = n(0), a = i.default.OVERLAY, s = i.default.SHOW_MODAL, c = i.default.BUTTON,
            l = i.default.BUTTON_LOADING, u = n(5);
        e.openModal = function () {
            o.getNode(a).classList.add(s), u.default.isOpen = !0
        };
        var f = function () {
            o.getNode(a).classList.remove(s), u.default.isOpen = !1
        };
        e.onAction = function (t) {
            void 0 === t && (t = r.CANCEL_KEY);
            var e = u.default.actions[t], n = e.value;
            if (!1 === e.closeModal) {
                var i = c+"--"+t;
                o.getNode(i).classList.add(l)
            } else f();
            u.default.promise.resolve(n)
        }, e.getState = function () {
            var t = Object.assign({}, u.default);
            return delete t.promise, delete t.timer, t
        }, e.stopLoading = function () {
            for (var t = document.querySelectorAll("."+c), e = 0; e < t.length; e++) {
                t[e].classList.remove(l)
            }
        }
    }, function (t, e) {
        var n;
        n = function () {
            return this
        }();
        try {
            n = n || Function("return this")() || (0, eval)("this")
        } catch (t) {
            "object" == typeof window && (n = window)
        }
        t.exports = n
    }, function (t, e, n) {
        (function (e) {
            t.exports = e.sweetAlert = n(9)
        }).call(e, n(7))
    }, function (t, e, n) {
        (function (e) {
            t.exports = e.swal = n(10)
        }).call(e, n(7))
    }, function (t, e, n) {
        "undefined" != typeof window && n(11), n(16);
        var o = n(23).default;
        t.exports = o
    }, function (t, e, n) {
        var o = n(12);
        "string" == typeof o && (o = [[t.i, o, ""]]);
        var r = {insertAt: "top"};
        r.transform = void 0;
        n(14)(o, r);
        o.locals && (t.exports = o.locals)
    }, function (t, e, n) {
        e = t.exports = n(13)(void 0), e.push([t.i, '.swal-icon--error{border-color:#f27474;-webkit-animation:animateErrorIcon .5s;animation:animateErrorIcon .5s}.swal-icon--error__x-mark{position:relative;display:block;-webkit-animation:animateXMark .5s;animation:animateXMark .5s}.swal-icon--error__line{position:absolute;height:5px;width:47px;background-color:#f27474;display:block;top:37px;border-radius:2px}.swal-icon--error__line--left{-webkit-transform:rotate(45deg);transform:rotate(45deg);left:17px}.swal-icon--error__line--right{-webkit-transform:rotate(-45deg);transform:rotate(-45deg);right:16px}@-webkit-keyframes animateErrorIcon{0%{-webkit-transform:rotateX(100deg);transform:rotateX(100deg);opacity:0}to{-webkit-transform:rotateX(0deg);transform:rotateX(0deg);opacity:1}}@keyframes animateErrorIcon{0%{-webkit-transform:rotateX(100deg);transform:rotateX(100deg);opacity:0}to{-webkit-transform:rotateX(0deg);transform:rotateX(0deg);opacity:1}}@-webkit-keyframes animateXMark{0%{-webkit-transform:scale(.4);transform:scale(.4);margin-top:26px;opacity:0}50%{-webkit-transform:scale(.4);transform:scale(.4);margin-top:26px;opacity:0}80%{-webkit-transform:scale(1.15);transform:scale(1.15);margin-top:-6px}to{-webkit-transform:scale(1);transform:scale(1);margin-top:0;opacity:1}}@keyframes animateXMark{0%{-webkit-transform:scale(.4);transform:scale(.4);margin-top:26px;opacity:0}50%{-webkit-transform:scale(.4);transform:scale(.4);margin-top:26px;opacity:0}80%{-webkit-transform:scale(1.15);transform:scale(1.15);margin-top:-6px}to{-webkit-transform:scale(1);transform:scale(1);margin-top:0;opacity:1}}.swal-icon--warning{border-color:#f8bb86;-webkit-animation:pulseWarning .75s infinite alternate;animation:pulseWarning .75s infinite alternate}.swal-icon--warning__body{width:5px;height:47px;top:10px;border-radius:2px;margin-left:-2px}.swal-icon--warning__body,.swal-icon--warning__dot{position:absolute;left:50%;background-color:#f8bb86}.swal-icon--warning__dot{width:7px;height:7px;border-radius:50%;margin-left:-4px;bottom:-11px}@-webkit-keyframes pulseWarning{0%{border-color:#f8d486}to{border-color:#f8bb86}}@keyframes pulseWarning{0%{border-color:#f8d486}to{border-color:#f8bb86}}.swal-icon--success{border-color:#a5dc86}.swal-icon--success:after,.swal-icon--success:before{content:"";border-radius:50%;position:absolute;width:60px;height:120px;background:#fff;-webkit-transform:rotate(45deg);transform:rotate(45deg)}.swal-icon--success:before{border-radius:120px 0 0 120px;top:-7px;left:-33px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-transform-origin:60px 60px;transform-origin:60px 60px}.swal-icon--success:after{border-radius:0 120px 120px 0;top:-11px;left:30px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-transform-origin:0 60px;transform-origin:0 60px;-webkit-animation:rotatePlaceholder 4.25s ease-in;animation:rotatePlaceholder 4.25s ease-in}.swal-icon--success__ring{width:80px;height:80px;border:4px solid hsla(98,55%,69%,.2);border-radius:50%;box-sizing:content-box;position:absolute;left:-4px;top:-4px;z-index:2}.swal-icon--success__hide-corners{width:5px;height:90px;background-color:#fff;padding:1px;position:absolute;left:28px;top:8px;z-index:1;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.swal-icon--success__line{height:5px;background-color:#a5dc86;display:block;border-radius:2px;position:absolute;z-index:2}.swal-icon--success__line--tip{width:25px;left:14px;top:46px;-webkit-transform:rotate(45deg);transform:rotate(45deg);-webkit-animation:animateSuccessTip .75s;animation:animateSuccessTip .75s}.swal-icon--success__line--long{width:47px;right:8px;top:38px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg);-webkit-animation:animateSuccessLong .75s;animation:animateSuccessLong .75s}@-webkit-keyframes rotatePlaceholder{0%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}5%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}12%{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}to{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}}@keyframes rotatePlaceholder{0%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}5%{-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}12%{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}to{-webkit-transform:rotate(-405deg);transform:rotate(-405deg)}}@-webkit-keyframes animateSuccessTip{0%{width:0;left:1px;top:19px}54%{width:0;left:1px;top:19px}70%{width:50px;left:-8px;top:37px}84%{width:17px;left:21px;top:48px}to{width:25px;left:14px;top:45px}}@keyframes animateSuccessTip{0%{width:0;left:1px;top:19px}54%{width:0;left:1px;top:19px}70%{width:50px;left:-8px;top:37px}84%{width:17px;left:21px;top:48px}to{width:25px;left:14px;top:45px}}@-webkit-keyframes animateSuccessLong{0%{width:0;right:46px;top:54px}65%{width:0;right:46px;top:54px}84%{width:55px;right:0;top:35px}to{width:47px;right:8px;top:38px}}@keyframes animateSuccessLong{0%{width:0;right:46px;top:54px}65%{width:0;right:46px;top:54px}84%{width:55px;right:0;top:35px}to{width:47px;right:8px;top:38px}}.swal-icon--info{border-color:#c9dae1}.swal-icon--info:before{width:5px;height:29px;bottom:17px;border-radius:2px;margin-left:-2px}.swal-icon--info:after,.swal-icon--info:before{content:"";position:absolute;left:50%;background-color:#c9dae1}.swal-icon--info:after{width:7px;height:7px;border-radius:50%;margin-left:-3px;top:19px}.swal-icon{width:80px;height:80px;border-width:4px;border-style:solid;border-radius:50%;padding:0;position:relative;box-sizing:content-box;margin:20px auto}.swal-icon:first-child{margin-top:32px}.swal-icon--custom{width:auto;height:auto;max-width:100%;border:none;border-radius:0}.swal-icon img{max-width:100%;max-height:100%}.swal-title{color:rgba(0,0,0,.65);font-weight:600;text-transform:none;position:relative;display:block;padding:13px 16px;font-size:27px;line-height:normal;text-align:center;margin-bottom:0}.swal-title:first-child{margin-top:26px}.swal-title:not(:first-child){padding-bottom:0}.swal-title:not(:last-child){margin-bottom:13px}.swal-text{font-size:16px;position:relative;float:none;line-height:normal;vertical-align:top;text-align:left;display:inline-block;margin:0;padding:0 10px;font-weight:400;color:rgba(0,0,0,.64);max-width:calc(100% - 20px);overflow-wrap:break-word;box-sizing:border-box}.swal-text:first-child{margin-top:45px}.swal-text:last-child{margin-bottom:45px}.swal-footer{text-align:right;padding-top:13px;margin-top:13px;padding:13px 16px;border-radius:inherit;border-top-left-radius:0;border-top-right-radius:0}.swal-button-container{margin:5px;display:inline-block;position:relative}.swal-button{background-color:#7cd1f9;color:#fff;border:none;box-shadow:none;border-radius:5px;font-weight:600;font-size:14px;padding:10px 24px;margin:0;cursor:pointer}.swal-button:not([disabled]):hover{background-color:#78cbf2}.swal-button:active{background-color:#70bce0}.swal-button:focus{outline:none;box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(43,114,165,.29)}.swal-button[disabled]{opacity:.5;cursor:default}.swal-button::-moz-focus-inner{border:0}.swal-button--cancel{color:#555;background-color:#efefef}.swal-button--cancel:not([disabled]):hover{background-color:#e8e8e8}.swal-button--cancel:active{background-color:#d7d7d7}.swal-button--cancel:focus{box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(116,136,150,.29)}.swal-button--danger{background-color:#e64942}.swal-button--danger:not([disabled]):hover{background-color:#df4740}.swal-button--danger:active{background-color:#cf423b}.swal-button--danger:focus{box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(165,43,43,.29)}.swal-content{padding:0 20px;margin-top:20px;font-size:medium}.swal-content:last-child{margin-bottom:20px}.swal-content__input,.swal-content__textarea{-webkit-appearance:none;background-color:#fff;border:none;font-size:14px;display:block;box-sizing:border-box;width:100%;border:1px solid rgba(0,0,0,.14);padding:10px 13px;border-radius:2px;transition:border-color .2s}.swal-content__input:focus,.swal-content__textarea:focus{outline:none;border-color:#6db8ff}.swal-content__textarea{resize:vertical}.swal-button--loading{color:transparent}.swal-button--loading~.swal-button__loader{opacity:1}.swal-button__loader{position:absolute;height:auto;width:43px;z-index:2;left:50%;top:50%;-webkit-transform:translateX(-50%) translateY(-50%);transform:translateX(-50%) translateY(-50%);text-align:center;pointer-events:none;opacity:0}.swal-button__loader div{display:inline-block;float:none;vertical-align:baseline;width:9px;height:9px;padding:0;border:none;margin:2px;opacity:.4;border-radius:7px;background-color:hsla(0,0%,100%,.9);transition:background .2s;-webkit-animation:swal-loading-anim 1s infinite;animation:swal-loading-anim 1s infinite}.swal-button__loader div:nth-child(3n+2){-webkit-animation-delay:.15s;animation-delay:.15s}.swal-button__loader div:nth-child(3n+3){-webkit-animation-delay:.3s;animation-delay:.3s}@-webkit-keyframes swal-loading-anim{0%{opacity:.4}20%{opacity:.4}50%{opacity:1}to{opacity:.4}}@keyframes swal-loading-anim{0%{opacity:.4}20%{opacity:.4}50%{opacity:1}to{opacity:.4}}.swal-overlay{position:fixed;top:0;bottom:0;left:0;right:0;text-align:center;font-size:0;overflow-y:auto;background-color:rgba(0,0,0,.4);z-index:10000;pointer-events:none;opacity:0;transition:opacity .3s}.swal-overlay:before{content:" ";display:inline-block;vertical-align:middle;height:100%}.swal-overlay--show-modal{opacity:1;pointer-events:auto}.swal-overlay--show-modal .swal-modal{opacity:1;pointer-events:auto;box-sizing:border-box;-webkit-animation:showSweetAlert .3s;animation:showSweetAlert .3s;will-change:transform}.swal-modal{width:478px;opacity:0;pointer-events:none;background-color:#fff;text-align:center;border-radius:5px;position:static;margin:20px auto;display:inline-block;vertical-align:middle;-webkit-transform:scale(1);transform:scale(1);-webkit-transform-origin:50% 50%;transform-origin:50% 50%;z-index:10001;transition:opacity .2s,-webkit-transform .3s;transition:transform .3s,opacity .2s;transition:transform .3s,opacity .2s,-webkit-transform .3s}@media (max-width:500px){.swal-modal{width:calc(100% - 20px)}}@-webkit-keyframes showSweetAlert{0%{-webkit-transform:scale(1);transform:scale(1)}1%{-webkit-transform:scale(.5);transform:scale(.5)}45%{-webkit-transform:scale(1.05);transform:scale(1.05)}80%{-webkit-transform:scale(.95);transform:scale(.95)}to{-webkit-transform:scale(1);transform:scale(1)}}@keyframes showSweetAlert{0%{-webkit-transform:scale(1);transform:scale(1)}1%{-webkit-transform:scale(.5);transform:scale(.5)}45%{-webkit-transform:scale(1.05);transform:scale(1.05)}80%{-webkit-transform:scale(.95);transform:scale(.95)}to{-webkit-transform:scale(1);transform:scale(1)}}', ""])
    }, function (t, e) {
        function n(t, e) {
            var n = t[1] || "", r = t[3];
            if (!r) return n;
            if (e && "function" == typeof btoa) {
                var i = o(r);
                return [n].concat(r.sources.map(function (t) {
                    return "/*# sourceURL="+r.sourceRoot+t+" */"
                })).concat([i]).join("\n")
            }
            return [n].join("\n")
        }

        function o(t) {
            return "/*# sourceMappingURL=data:application/json;charset=utf-8;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(t))))+" */"
        }

        t.exports = function (t) {
            var e = [];
            return e.toString = function () {
                return this.map(function (e) {
                    var o = n(e, t);
                    return e[2] ? "@media "+e[2]+"{"+o+"}" : o
                }).join("")
            }, e.i = function (t, n) {
                "string" == typeof t && (t = [[null, t, ""]]);
                for (var o = {}, r = 0; r < this.length; r++) {
                    var i = this[r][0];
                    "number" == typeof i && (o[i] = !0)
                }
                for (r = 0; r < t.length; r++) {
                    var a = t[r];
                    "number" == typeof a[0] && o[a[0]] || (n && !a[2] ? a[2] = n : n && (a[2] = "("+a[2]+") and ("+n+")"), e.push(a))
                }
            }, e
        }
    }, function (t, e, n) {
        function o(t, e) {
            for (var n = 0; n < t.length; n++) {
                var o = t[n], r = m[o.id];
                if (r) {
                    r.refs++;
                    for (var i = 0; i < r.parts.length; i++) r.parts[i](o.parts[i]);
                    for (; i < o.parts.length; i++) r.parts.push(u(o.parts[i], e))
                } else {
                    for (var a = [], i = 0; i < o.parts.length; i++) a.push(u(o.parts[i], e));
                    m[o.id] = {id: o.id, refs: 1, parts: a}
                }
            }
        }

        function r(t, e) {
            for (var n = [], o = {}, r = 0; r < t.length; r++) {
                var i = t[r], a = e.base ? i[0]+e.base : i[0], s = i[1], c = i[2], l = i[3],
                    u = {css: s, media: c, sourceMap: l};
                o[a] ? o[a].parts.push(u) : n.push(o[a] = {id: a, parts: [u]})
            }
            return n
        }

        function i(t, e) {
            var n = v(t.insertInto);
            if (!n) throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
            var o = w[w.length-1];
            if ("top" === t.insertAt) o ? o.nextSibling ? n.insertBefore(e, o.nextSibling) : n.appendChild(e) : n.insertBefore(e, n.firstChild), w.push(e); else {
                if ("bottom" !== t.insertAt) throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");
                n.appendChild(e)
            }
        }

        function a(t) {
            if (null === t.parentNode) return !1;
            t.parentNode.removeChild(t);
            var e = w.indexOf(t);
            e >= 0 && w.splice(e, 1)
        }

        function s(t) {
            var e = document.createElement("style");
            return t.attrs.type = "text/css", l(e, t.attrs), i(t, e), e
        }

        function c(t) {
            var e = document.createElement("link");
            return t.attrs.type = "text/css", t.attrs.rel = "stylesheet", l(e, t.attrs), i(t, e), e
        }

        function l(t, e) {
            Object.keys(e).forEach(function (n) {
                t.setAttribute(n, e[n])
            })
        }

        function u(t, e) {
            var n, o, r, i;
            if (e.transform && t.css) {
                if (!(i = e.transform(t.css))) return function () {
                };
                t.css = i
            }
            if (e.singleton) {
                var l = h++;
                n = g || (g = s(e)), o = f.bind(null, n, l, !1), r = f.bind(null, n, l, !0)
            } else t.sourceMap && "function" == typeof URL && "function" == typeof URL.createObjectURL && "function" == typeof URL.revokeObjectURL && "function" == typeof Blob && "function" == typeof btoa ? (n = c(e), o = p.bind(null, n, e), r = function () {
                a(n), n.href && URL.revokeObjectURL(n.href)
            }) : (n = s(e), o = d.bind(null, n), r = function () {
                a(n)
            });
            return o(t), function (e) {
                if (e) {
                    if (e.css === t.css && e.media === t.media && e.sourceMap === t.sourceMap) return;
                    o(t = e)
                } else r()
            }
        }

        function f(t, e, n, o) {
            var r = n ? "" : o.css;
            if (t.styleSheet) t.styleSheet.cssText = x(e, r); else {
                var i = document.createTextNode(r), a = t.childNodes;
                a[e] && t.removeChild(a[e]), a.length ? t.insertBefore(i, a[e]) : t.appendChild(i)
            }
        }

        function d(t, e) {
            var n = e.css, o = e.media;
            if (o && t.setAttribute("media", o), t.styleSheet) t.styleSheet.cssText = n; else {
                for (; t.firstChild;) t.removeChild(t.firstChild);
                t.appendChild(document.createTextNode(n))
            }
        }

        function p(t, e, n) {
            var o = n.css, r = n.sourceMap, i = void 0 === e.convertToAbsoluteUrls && r;
            (e.convertToAbsoluteUrls || i) && (o = y(o)), r && (o += "\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(r))))+" */");
            var a = new Blob([o], {type: "text/css"}), s = t.href;
            t.href = URL.createObjectURL(a), s && URL.revokeObjectURL(s)
        }

        var m = {}, b = function (t) {
            var e;
            return function () {
                return void 0 === e && (e = t.apply(this, arguments)), e
            }
        }(function () {
            return window && document && document.all && !window.atob
        }), v = function (t) {
            var e = {};
            return function (n) {
                return void 0 === e[n] && (e[n] = t.call(this, n)), e[n]
            }
        }(function (t) {
            return document.querySelector(t)
        }), g = null, h = 0, w = [], y = n(15);
        t.exports = function (t, e) {
            if ("undefined" != typeof DEBUG && DEBUG && "object" != typeof document) throw new Error("The style-loader cannot be used in a non-browser environment");
            e = e || {}, e.attrs = "object" == typeof e.attrs ? e.attrs : {}, e.singleton || (e.singleton = b()), e.insertInto || (e.insertInto = "head"), e.insertAt || (e.insertAt = "bottom");
            var n = r(t, e);
            return o(n, e), function (t) {
                for (var i = [], a = 0; a < n.length; a++) {
                    var s = n[a], c = m[s.id];
                    c.refs--, i.push(c)
                }
                if (t) {
                    o(r(t, e), e)
                }
                for (var a = 0; a < i.length; a++) {
                    var c = i[a];
                    if (0 === c.refs) {
                        for (var l = 0; l < c.parts.length; l++) c.parts[l]();
                        delete m[c.id]
                    }
                }
            }
        };
        var x = function () {
            var t = [];
            return function (e, n) {
                return t[e] = n, t.filter(Boolean).join("\n")
            }
        }()
    }, function (t, e) {
        t.exports = function (t) {
            var e = "undefined" != typeof window && window.location;
            if (!e) throw new Error("fixUrls requires window.location");
            if (!t || "string" != typeof t) return t;
            var n = e.protocol+"//"+e.host, o = n+e.pathname.replace(/\/[^\/]*$/, "/");
            return t.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi, function (t, e) {
                var r = e.trim().replace(/^"(.*)"$/, function (t, e) {
                    return e
                }).replace(/^'(.*)'$/, function (t, e) {
                    return e
                });
                if (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/)/i.test(r)) return t;
                var i;
                return i = 0 === r.indexOf("//") ? r : 0 === r.indexOf("/") ? n+r : o+r.replace(/^\.\//, ""), "url("+JSON.stringify(i)+")"
            })
        }
    }, function (t, e, n) {
        var o = n(17);
        "undefined" == typeof window || window.Promise || (window.Promise = o), n(21), String.prototype.includes || (String.prototype.includes = function (t, e) {
            "use strict";
            return "number" != typeof e && (e = 0), !(e+t.length > this.length) && -1 !== this.indexOf(t, e)
        }), Array.prototype.includes || Object.defineProperty(Array.prototype, "includes", {
            value: function (t, e) {
                if (null == this) throw new TypeError('"this" is null or not defined');
                var n = Object(this), o = n.length >>> 0;
                if (0 === o) return !1;
                for (var r = 0 | e, i = Math.max(r >= 0 ? r : o-Math.abs(r), 0); i < o;) {
                    if (function (t, e) {
                        return t === e || "number" == typeof t && "number" == typeof e && isNaN(t) && isNaN(e)
                    }(n[i], t)) return !0;
                    i++
                }
                return !1
            }
        }), "undefined" != typeof window && function (t) {
            t.forEach(function (t) {
                t.hasOwnProperty("remove") || Object.defineProperty(t, "remove", {
                    configurable: !0,
                    enumerable: !0,
                    writable: !0,
                    value: function () {
                        this.parentNode.removeChild(this)
                    }
                })
            })
        }([Element.prototype, CharacterData.prototype, DocumentType.prototype])
    }, function (t, e, n) {
        (function (e) {
            !function (n) {
                function o() {
                }

                function r(t, e) {
                    return function () {
                        t.apply(e, arguments)
                    }
                }

                function i(t) {
                    if ("object" != typeof this) throw new TypeError("Promises must be constructed via new");
                    if ("function" != typeof t) throw new TypeError("not a function");
                    this._state = 0, this._handled = !1, this._value = void 0, this._deferreds = [], f(t, this)
                }

                function a(t, e) {
                    for (; 3 === t._state;) t = t._value;
                    if (0 === t._state) return void t._deferreds.push(e);
                    t._handled = !0, i._immediateFn(function () {
                        var n = 1 === t._state ? e.onFulfilled : e.onRejected;
                        if (null === n) return void (1 === t._state ? s : c)(e.promise, t._value);
                        var o;
                        try {
                            o = n(t._value)
                        } catch (t) {
                            return void c(e.promise, t)
                        }
                        s(e.promise, o)
                    })
                }

                function s(t, e) {
                    try {
                        if (e === t) throw new TypeError("A promise cannot be resolved with itself.");
                        if (e && ("object" == typeof e || "function" == typeof e)) {
                            var n = e.then;
                            if (e instanceof i) return t._state = 3, t._value = e, void l(t);
                            if ("function" == typeof n) return void f(r(n, e), t)
                        }
                        t._state = 1, t._value = e, l(t)
                    } catch (e) {
                        c(t, e)
                    }
                }

                function c(t, e) {
                    t._state = 2, t._value = e, l(t)
                }

                function l(t) {
                    2 === t._state && 0 === t._deferreds.length && i._immediateFn(function () {
                        t._handled || i._unhandledRejectionFn(t._value)
                    });
                    for (var e = 0, n = t._deferreds.length; e < n; e++) a(t, t._deferreds[e]);
                    t._deferreds = null
                }

                function u(t, e, n) {
                    this.onFulfilled = "function" == typeof t ? t : null, this.onRejected = "function" == typeof e ? e : null, this.promise = n
                }

                function f(t, e) {
                    var n = !1;
                    try {
                        t(function (t) {
                            n || (n = !0, s(e, t))
                        }, function (t) {
                            n || (n = !0, c(e, t))
                        })
                    } catch (t) {
                        if (n) return;
                        n = !0, c(e, t)
                    }
                }

                var d = setTimeout;
                i.prototype.catch = function (t) {
                    return this.then(null, t)
                }, i.prototype.then = function (t, e) {
                    var n = new this.constructor(o);
                    return a(this, new u(t, e, n)), n
                }, i.all = function (t) {
                    var e = Array.prototype.slice.call(t);
                    return new i(function (t, n) {
                        function o(i, a) {
                            try {
                                if (a && ("object" == typeof a || "function" == typeof a)) {
                                    var s = a.then;
                                    if ("function" == typeof s) return void s.call(a, function (t) {
                                        o(i, t)
                                    }, n)
                                }
                                e[i] = a, 0 == --r && t(e)
                            } catch (t) {
                                n(t)
                            }
                        }

                        if (0 === e.length) return t([]);
                        for (var r = e.length, i = 0; i < e.length; i++) o(i, e[i])
                    })
                }, i.resolve = function (t) {
                    return t && "object" == typeof t && t.constructor === i ? t : new i(function (e) {
                        e(t)
                    })
                }, i.reject = function (t) {
                    return new i(function (e, n) {
                        n(t)
                    })
                }, i.race = function (t) {
                    return new i(function (e, n) {
                        for (var o = 0, r = t.length; o < r; o++) t[o].then(e, n)
                    })
                }, i._immediateFn = "function" == typeof e && function (t) {
                    e(t)
                } || function (t) {
                    d(t, 0)
                }, i._unhandledRejectionFn = function (t) {
                    "undefined" != typeof console && console && console.warn("Possible Unhandled Promise Rejection:", t)
                }, i._setImmediateFn = function (t) {
                    i._immediateFn = t
                }, i._setUnhandledRejectionFn = function (t) {
                    i._unhandledRejectionFn = t
                }, void 0 !== t && t.exports ? t.exports = i : n.Promise || (n.Promise = i)
            }(this)
        }).call(e, n(18).setImmediate)
    }, function (t, e, n) {
        function o(t, e) {
            this._id = t, this._clearFn = e
        }

        var r = Function.prototype.apply;
        e.setTimeout = function () {
            return new o(r.call(setTimeout, window, arguments), clearTimeout)
        }, e.setInterval = function () {
            return new o(r.call(setInterval, window, arguments), clearInterval)
        }, e.clearTimeout = e.clearInterval = function (t) {
            t && t.close()
        }, o.prototype.unref = o.prototype.ref = function () {
        }, o.prototype.close = function () {
            this._clearFn.call(window, this._id)
        }, e.enroll = function (t, e) {
            clearTimeout(t._idleTimeoutId), t._idleTimeout = e
        }, e.unenroll = function (t) {
            clearTimeout(t._idleTimeoutId), t._idleTimeout = -1
        }, e._unrefActive = e.active = function (t) {
            clearTimeout(t._idleTimeoutId);
            var e = t._idleTimeout;
            e >= 0 && (t._idleTimeoutId = setTimeout(function () {
                t._onTimeout && t._onTimeout()
            }, e))
        }, n(19), e.setImmediate = setImmediate, e.clearImmediate = clearImmediate
    }, function (t, e, n) {
        (function (t, e) {
            !function (t, n) {
                "use strict";

                function o(t) {
                    "function" != typeof t && (t = new Function(""+t));
                    for (var e = new Array(arguments.length-1), n = 0; n < e.length; n++) e[n] = arguments[n+1];
                    var o = {callback: t, args: e};
                    return l[c] = o, s(c), c++
                }

                function r(t) {
                    delete l[t]
                }

                function i(t) {
                    var e = t.callback, o = t.args;
                    switch (o.length) {
                        case 0:
                            e();
                            break;
                        case 1:
                            e(o[0]);
                            break;
                        case 2:
                            e(o[0], o[1]);
                            break;
                        case 3:
                            e(o[0], o[1], o[2]);
                            break;
                        default:
                            e.apply(n, o)
                    }
                }

                function a(t) {
                    if (u) setTimeout(a, 0, t); else {
                        var e = l[t];
                        if (e) {
                            u = !0;
                            try {
                                i(e)
                            } finally {
                                r(t), u = !1
                            }
                        }
                    }
                }

                if (!t.setImmediate) {
                    var s, c = 1, l = {}, u = !1, f = t.document, d = Object.getPrototypeOf && Object.getPrototypeOf(t);
                    d = d && d.setTimeout ? d : t, "[object process]" === {}.toString.call(t.process) ? function () {
                        s = function (t) {
                            e.nextTick(function () {
                                a(t)
                            })
                        }
                    }() : function () {
                        if (t.postMessage && !t.importScripts) {
                            var e = !0, n = t.onmessage;
                            return t.onmessage = function () {
                                e = !1
                            }, t.postMessage("", "*"), t.onmessage = n, e
                        }
                    }() ? function () {
                        var e = "setImmediate$"+Math.random()+"$", n = function (n) {
                            n.source === t && "string" == typeof n.data && 0 === n.data.indexOf(e) && a(+n.data.slice(e.length))
                        };
                        t.addEventListener ? t.addEventListener("message", n, !1) : t.attachEvent("onmessage", n), s = function (n) {
                            t.postMessage(e+n, "*")
                        }
                    }() : t.MessageChannel ? function () {
                        var t = new MessageChannel;
                        t.port1.onmessage = function (t) {
                            a(t.data)
                        }, s = function (e) {
                            t.port2.postMessage(e)
                        }
                    }() : f && "onreadystatechange" in f.createElement("script") ? function () {
                        var t = f.documentElement;
                        s = function (e) {
                            var n = f.createElement("script");
                            n.onreadystatechange = function () {
                                a(e), n.onreadystatechange = null, t.removeChild(n), n = null
                            }, t.appendChild(n)
                        }
                    }() : function () {
                        s = function (t) {
                            setTimeout(a, 0, t)
                        }
                    }(), d.setImmediate = o, d.clearImmediate = r
                }
            }("undefined" == typeof self ? void 0 === t ? this : t : self)
        }).call(e, n(7), n(20))
    }, function (t, e) {
        function n() {
            throw new Error("setTimeout has not been defined")
        }

        function o() {
            throw new Error("clearTimeout has not been defined")
        }

        function r(t) {
            if (u === setTimeout) return setTimeout(t, 0);
            if ((u === n || !u) && setTimeout) return u = setTimeout, setTimeout(t, 0);
            try {
                return u(t, 0)
            } catch (e) {
                try {
                    return u.call(null, t, 0)
                } catch (e) {
                    return u.call(this, t, 0)
                }
            }
        }

        function i(t) {
            if (f === clearTimeout) return clearTimeout(t);
            if ((f === o || !f) && clearTimeout) return f = clearTimeout, clearTimeout(t);
            try {
                return f(t)
            } catch (e) {
                try {
                    return f.call(null, t)
                } catch (e) {
                    return f.call(this, t)
                }
            }
        }

        function a() {
            b && p && (b = !1, p.length ? m = p.concat(m) : v = -1, m.length && s())
        }

        function s() {
            if (!b) {
                var t = r(a);
                b = !0;
                for (var e = m.length; e;) {
                    for (p = m, m = []; ++v < e;) p && p[v].run();
                    v = -1, e = m.length
                }
                p = null, b = !1, i(t)
            }
        }

        function c(t, e) {
            this.fun = t, this.array = e
        }

        function l() {
        }

        var u, f, d = t.exports = {};
        !function () {
            try {
                u = "function" == typeof setTimeout ? setTimeout : n
            } catch (t) {
                u = n
            }
            try {
                f = "function" == typeof clearTimeout ? clearTimeout : o
            } catch (t) {
                f = o
            }
        }();
        var p, m = [], b = !1, v = -1;
        d.nextTick = function (t) {
            var e = new Array(arguments.length-1);
            if (arguments.length > 1) for (var n = 1; n < arguments.length; n++) e[n-1] = arguments[n];
            m.push(new c(t, e)), 1 !== m.length || b || r(s)
        }, c.prototype.run = function () {
            this.fun.apply(null, this.array)
        }, d.title = "browser", d.browser = !0, d.env = {}, d.argv = [], d.version = "", d.versions = {}, d.on = l, d.addListener = l, d.once = l, d.off = l, d.removeListener = l, d.removeAllListeners = l, d.emit = l, d.prependListener = l, d.prependOnceListener = l, d.listeners = function (t) {
            return []
        }, d.binding = function (t) {
            throw new Error("process.binding is not supported")
        }, d.cwd = function () {
            return "/"
        }, d.chdir = function (t) {
            throw new Error("process.chdir is not supported")
        }, d.umask = function () {
            return 0
        }
    }, function (t, e, n) {
        "use strict";
        n(22).polyfill()
    }, function (t, e, n) {
        "use strict";

        function o(t, e) {
            if (void 0 === t || null === t) throw new TypeError("Cannot convert first argument to object");
            for (var n = Object(t), o = 1; o < arguments.length; o++) {
                var r = arguments[o];
                if (void 0 !== r && null !== r) for (var i = Object.keys(Object(r)), a = 0, s = i.length; a < s; a++) {
                    var c = i[a], l = Object.getOwnPropertyDescriptor(r, c);
                    void 0 !== l && l.enumerable && (n[c] = r[c])
                }
            }
            return n
        }

        function r() {
            Object.assign || Object.defineProperty(Object, "assign", {
                enumerable: !1,
                configurable: !0,
                writable: !0,
                value: o
            })
        }

        t.exports = {assign: o, polyfill: r}
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(24), r = n(6), i = n(5), a = n(36), s = function () {
            for (var t = [], e = 0; e < arguments.length; e++) t[e] = arguments[e];
            if ("undefined" != typeof window) {
                var n = a.getOpts.apply(void 0, t);
                return new Promise(function (t, e) {
                    i.default.promise = {resolve: t, reject: e}, o.default(n), setTimeout(function () {
                        r.openModal()
                    })
                })
            }
        };
        s.close = r.onAction, s.getState = r.getState, s.setActionValue = i.setActionValue, s.stopLoading = r.stopLoading, s.setDefaults = a.setDefaults, e.default = s
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(1), r = n(0), i = r.default.MODAL, a = n(4), s = n(34), c = n(35), l = n(1);
        e.init = function (t) {
            o.getNode(i) || (document.body || l.throwErr("You can only use SweetAlert AFTER the DOM has loaded!"), s.default(), a.default()), a.initModalContent(t), c.default(t)
        }, e.default = e.init
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(0), r = o.default.MODAL;
        e.modalMarkup = '\n  <div class="'+r+'" role="dialog" aria-modal="true"></div>', e.default = e.modalMarkup
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(0), r = o.default.OVERLAY, i = '<div \n    class="'+r+'"\n    tabIndex="-1">\n  </div>';
        e.default = i
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(0), r = o.default.ICON;
        e.errorIconMarkup = function () {
            var t = r+"--error", e = t+"__line";
            return '\n    <div class="'+t+'__x-mark">\n      <span class="'+e+" "+e+'--left"></span>\n      <span class="'+e+" "+e+'--right"></span>\n    </div>\n  '
        }, e.warningIconMarkup = function () {
            var t = r+"--warning";
            return '\n    <span class="'+t+'__body">\n      <span class="'+t+'__dot"></span>\n    </span>\n  '
        }, e.successIconMarkup = function () {
            var t = r+"--success";
            return '\n    <span class="'+t+"__line "+t+'__line--long"></span>\n    <span class="'+t+"__line "+t+'__line--tip"></span>\n\n    <div class="'+t+'__ring"></div>\n    <div class="'+t+'__hide-corners"></div>\n  '
        }
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(0), r = o.default.CONTENT;
        e.contentMarkup = '\n  <div class="'+r+'">\n\n  </div>\n'
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(0), r = o.default.BUTTON_CONTAINER, i = o.default.BUTTON, a = o.default.BUTTON_LOADER;
        e.buttonMarkup = '\n  <div class="'+r+'">\n\n    <button\n      class="'+i+'"\n    ></button>\n\n    <div class="'+a+'">\n      <div></div>\n      <div></div>\n      <div></div>\n    </div>\n\n  </div>\n'
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(4), r = n(2), i = n(0), a = i.default.ICON, s = i.default.ICON_CUSTOM,
            c = ["error", "warning", "success", "info"],
            l = {error: r.errorIconMarkup(), warning: r.warningIconMarkup(), success: r.successIconMarkup()},
            u = function (t, e) {
                var n = a+"--"+t;
                e.classList.add(n);
                var o = l[t];
                o && (e.innerHTML = o)
            }, f = function (t, e) {
                e.classList.add(s);
                var n = document.createElement("img");
                n.src = t, e.appendChild(n)
            }, d = function (t) {
                if (t) {
                    var e = o.injectElIntoModal(r.iconMarkup);
                    c.includes(t) ? u(t, e) : f(t, e)
                }
            };
        e.default = d
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(2), r = n(4), i = function (t) {
            navigator.userAgent.includes("AppleWebKit") && (t.style.display = "none", t.offsetHeight, t.style.display = "")
        };
        e.initTitle = function (t) {
            if (t) {
                var e = r.injectElIntoModal(o.titleMarkup);
                e.textContent = t, i(e)
            }
        }, e.initText = function (t) {
            if (t) {
                var e = document.createDocumentFragment();
                t.split("\n").forEach(function (t, n, o) {
                    e.appendChild(document.createTextNode(t)), n < o.length-1 && e.appendChild(document.createElement("br"))
                });
                var n = r.injectElIntoModal(o.textMarkup);
                n.appendChild(e), i(n)
            }
        }
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(1), r = n(4), i = n(0), a = i.default.BUTTON, s = i.default.DANGER_BUTTON, c = n(3), l = n(2),
            u = n(6), f = n(5), d = function (t, e, n) {
                var r = e.text, i = e.value, d = e.className, p = e.closeModal, m = o.stringToNode(l.buttonMarkup),
                    b = m.querySelector("."+a), v = a+"--"+t;
                if (b.classList.add(v), d) {
                    (Array.isArray(d) ? d : d.split(" ")).filter(function (t) {
                        return t.length > 0
                    }).forEach(function (t) {
                        b.classList.add(t)
                    })
                }
                n && t === c.CONFIRM_KEY && b.classList.add(s), b.textContent = r;
                var g = {};
                return g[t] = i, f.setActionValue(g), f.setActionOptionsFor(t, {closeModal: p}), b.addEventListener("click", function () {
                    return u.onAction(t)
                }), m
            }, p = function (t, e) {
                var n = r.injectElIntoModal(l.footerMarkup);
                for (var o in t) {
                    var i = t[o], a = d(o, i, e);
                    i.visible && n.appendChild(a)
                }
                0 === n.children.length && n.remove()
            };
        e.default = p
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(3), r = n(4), i = n(2), a = n(5), s = n(6), c = n(0), l = c.default.CONTENT, u = function (t) {
            t.addEventListener("input", function (t) {
                var e = t.target, n = e.value;
                a.setActionValue(n)
            }), t.addEventListener("keyup", function (t) {
                if ("Enter" === t.key) return s.onAction(o.CONFIRM_KEY)
            }), setTimeout(function () {
                t.focus(), a.setActionValue("")
            }, 0)
        }, f = function (t, e, n) {
            var o = document.createElement(e), r = l+"__"+e;
            o.classList.add(r);
            for (var i in n) {
                var a = n[i];
                o[i] = a
            }
            "input" === e && u(o), t.appendChild(o)
        }, d = function (t) {
            if (t) {
                var e = r.injectElIntoModal(i.contentMarkup), n = t.element, o = t.attributes;
                "string" == typeof n ? f(e, n, o) : e.appendChild(n)
            }
        };
        e.default = d
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(1), r = n(2), i = function () {
            var t = o.stringToNode(r.overlayMarkup);
            document.body.appendChild(t)
        };
        e.default = i
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(5), r = n(6), i = n(1), a = n(3), s = n(0), c = s.default.MODAL, l = s.default.BUTTON,
            u = s.default.OVERLAY, f = function (t) {
                t.preventDefault(), v()
            }, d = function (t) {
                t.preventDefault(), g()
            }, p = function (t) {
                if (o.default.isOpen) switch (t.key) {
                    case"Escape":
                        return r.onAction(a.CANCEL_KEY)
                }
            }, m = function (t) {
                if (o.default.isOpen) switch (t.key) {
                    case"Tab":
                        return f(t)
                }
            }, b = function (t) {
                if (o.default.isOpen) return "Tab" === t.key && t.shiftKey ? d(t) : void 0
            }, v = function () {
                var t = i.getNode(l);
                t && (t.tabIndex = 0, t.focus())
            }, g = function () {
                var t = i.getNode(c), e = t.querySelectorAll("."+l), n = e.length-1, o = e[n];
                o && o.focus()
            }, h = function (t) {
                t[t.length-1].addEventListener("keydown", m)
            }, w = function (t) {
                t[0].addEventListener("keydown", b)
            }, y = function () {
                var t = i.getNode(c), e = t.querySelectorAll("."+l);
                e.length && (h(e), w(e))
            }, x = function (t) {
                if (i.getNode(u) === t.target) return r.onAction(a.CANCEL_KEY)
            }, _ = function (t) {
                var e = i.getNode(u);
                e.removeEventListener("click", x), t && e.addEventListener("click", x)
            }, k = function (t) {
                o.default.timer && clearTimeout(o.default.timer), t && (o.default.timer = window.setTimeout(function () {
                    return r.onAction(a.CANCEL_KEY)
                }, t))
            }, O = function (t) {
                t.closeOnEsc ? document.addEventListener("keyup", p) : document.removeEventListener("keyup", p), t.dangerMode ? v() : g(), y(), _(t.closeOnClickOutside), k(t.timer)
            };
        e.default = O
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(1), r = n(3), i = n(37), a = n(38), s = {
            title: null,
            text: null,
            icon: null,
            buttons: r.defaultButtonList,
            content: null,
            className: null,
            closeOnClickOutside: !0,
            closeOnEsc: !0,
            dangerMode: !1,
            timer: null
        }, c = Object.assign({}, s);
        e.setDefaults = function (t) {
            c = Object.assign({}, s, t)
        };
        var l = function (t) {
            var e = t && t.button, n = t && t.buttons;
            return void 0 !== e && void 0 !== n && o.throwErr("Cannot set both 'button' and 'buttons' options!"), void 0 !== e ? {confirm: e} : n
        }, u = function (t) {
            return o.ordinalSuffixOf(t+1)
        }, f = function (t, e) {
            o.throwErr(u(e)+" argument ('"+t+"') is invalid")
        }, d = function (t, e) {
            var n = t+1, r = e[n];
            o.isPlainObject(r) || void 0 === r || o.throwErr("Expected "+u(n)+" argument ('"+r+"') to be a plain object")
        }, p = function (t, e) {
            var n = t+1, r = e[n];
            void 0 !== r && o.throwErr("Unexpected "+u(n)+" argument ("+r+")")
        }, m = function (t, e, n, r) {
            var i = typeof e, a = "string" === i, s = e instanceof Element;
            if (a) {
                if (0 === n) return {text: e};
                if (1 === n) return {text: e, title: r[0]};
                if (2 === n) return d(n, r), {icon: e};
                f(e, n)
            } else {
                if (s && 0 === n) return d(n, r), {content: e};
                if (o.isPlainObject(e)) return p(n, r), e;
                f(e, n)
            }
        };
        e.getOpts = function () {
            for (var t = [], e = 0; e < arguments.length; e++) t[e] = arguments[e];
            var n = {};
            t.forEach(function (e, o) {
                var r = m(0, e, o, t);
                Object.assign(n, r)
            });
            var o = l(n);
            n.buttons = r.getButtonListOpts(o), delete n.button, n.content = i.getContentOpts(n.content);
            var u = Object.assign({}, s, c, n);
            return Object.keys(u).forEach(function (t) {
                a.DEPRECATED_OPTS[t] && a.logDeprecation(t)
            }), u
        }
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0});
        var o = n(1), r = {element: "input", attributes: {placeholder: ""}};
        e.getContentOpts = function (t) {
            var e = {};
            return o.isPlainObject(t) ? Object.assign(e, t) : t instanceof Element ? {element: t} : "input" === t ? r : null
        }
    }, function (t, e, n) {
        "use strict";
        Object.defineProperty(e, "__esModule", {value: !0}), e.logDeprecation = function (t) {
            var n = e.DEPRECATED_OPTS[t], o = n.onlyRename, r = n.replacement, i = n.subOption, a = n.link,
                s = o ? "renamed" : "deprecated", c = 'SweetAlert warning: "'+t+'" option has been '+s+".";
            if (r) {
                c += " Please use"+(i ? ' "'+i+'" in ' : " ")+'"'+r+'" instead.'
            }
            var l = "https://sweetalert.js.org";
            c += a ? " More details: "+l+a : " More details: "+l+"/guides/#upgrading-from-1x", console.warn(c)
        }, e.DEPRECATED_OPTS = {
            type: {replacement: "icon", link: "/docs/#icon"},
            imageUrl: {replacement: "icon", link: "/docs/#icon"},
            customClass: {replacement: "className", onlyRename: !0, link: "/docs/#classname"},
            imageSize: {},
            showCancelButton: {replacement: "buttons", link: "/docs/#buttons"},
            showConfirmButton: {replacement: "button", link: "/docs/#button"},
            confirmButtonText: {replacement: "button", link: "/docs/#button"},
            confirmButtonColor: {},
            cancelButtonText: {replacement: "buttons", link: "/docs/#buttons"},
            closeOnConfirm: {replacement: "button", subOption: "closeModal", link: "/docs/#button"},
            closeOnCancel: {replacement: "buttons", subOption: "closeModal", link: "/docs/#buttons"},
            showLoaderOnConfirm: {replacement: "buttons"},
            animation: {},
            inputType: {replacement: "content", link: "/docs/#content"},
            inputValue: {replacement: "content", link: "/docs/#content"},
            inputPlaceholder: {replacement: "content", link: "/docs/#content"},
            html: {replacement: "content", link: "/docs/#content"},
            allowEscapeKey: {replacement: "closeOnEsc", onlyRename: !0, link: "/docs/#closeonesc"},
            allowClickOutside: {replacement: "closeOnClickOutside", onlyRename: !0, link: "/docs/#closeonclickoutside"}
        }
    }])
});
/*!
 * jquery.waterfall.js
 * https://github.com/dio-el-claire/jquery.waterfall
 */
(function (e) {
    e.waterfall = function () {
        var t = [], n = e.Deferred(), r = 0;
        e.each(arguments, function (i, s) {
            t.push(function () {
                var i = [].slice.apply(arguments), o;
                if (typeof s == "function") {
                    if (!((o = s.apply(null, i)) && o.promise)) {
                        o = e.Deferred()[o === false ? "reject" : "resolve"](o)
                    }
                } else if (s && s.promise) {
                    o = s
                } else {
                    o = e.Deferred()[s === false ? "reject" : "resolve"](s)
                }
                o.fail(function () {
                    n.reject.apply(n, [].slice.apply(arguments))
                }).done(function (e) {
                    r++;
                    i.push(e);
                    r == t.length ? n.resolve.apply(n, i) : t[r].apply(null, i)
                })
            })
        });
        t.length ? t[0]() : n.resolve();
        return n
    }
})(jQuery);

/* ========================================================================
 * Bootstrap: transition.js v3.4.0
 * http://getbootstrap.com/javascript/#transitions
 * ========================================================================
 * Copyright 2011-2016 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
    'use strict';

    // CSS TRANSITION SUPPORT (Shoutout: http://www.modernizr.com/)
    // ============================================================

    function transitionEnd() {
        var el = document.createElement('bootstrap')

        var transEndEventNames = {
            WebkitTransition: 'webkitTransitionEnd',
            MozTransition: 'transitionend',
            OTransition: 'oTransitionEnd otransitionend',
            transition: 'transitionend'
        }

        for (var name in transEndEventNames) {
            if (el.style[name] !== undefined) {
                return {end: transEndEventNames[name]}
            }
        }

        return false // explicit for ie8 (  ._.)
    }

    // http://blog.alexmaccaw.com/css-transitions
    $.fn.emulateTransitionEnd = function (duration) {
        var called = false
        var $el = this
        $(this).one('bsTransitionEnd', function () {
            called = true
        })
        var callback = function () {
            if (!called) $($el).trigger($.support.transition.end)
        }
        setTimeout(callback, duration)
        return this
    }

    $(function () {
        $.support.transition = transitionEnd()

        if (!$.support.transition) return

        $.event.special.bsTransitionEnd = {
            bindType: $.support.transition.end,
            delegateType: $.support.transition.end,
            handle: function (e) {
                if ($(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
            }
        }
    })

}(jQuery);

/* ========================================================================
 * TastyIgniter: app.js v3.0.0
 * https://tastyigniter.com/docs/javascript
 * ======================================================================== */

if (window.jQuery === undefined)
    throw new Error('TastyIgniter Javascript requires jQuery.');

if (window.jQuery.request !== undefined)
    throw new Error('The TastyIgniter Javascript framework is already loaded.');

/*
 * Custom event that unifies document.ready with window.ajaxUpdateComplete
 *
 * $(document).render(function() { })
 * $(document).on('render', function() { })
 */
+function ($) {
    "use strict";

    $(document).ready(function () {
        $(document).trigger('render')
    })

    $(window).on('ajaxUpdateComplete', function () {
        $(document).trigger('render')
    })

    $.fn.render = function (callback) {
        $(document).on('render', callback)
    }
}(window.jQuery);

/*
 * TastyIgniter AJAX plugin..
 *
 * Adapted from OctoberCMS AJAX plugin
 *
 * $.request('handler', function() { })
 * $(form).request('handler', function() { })
 */
+function ($) {
    "use strict";

    // REQUEST CLASS DEFINITION
    // =========================

    var Request = function (element, handler, options) {
        var $el = this.$el = $(element)
        this.options = options || {}

        // Prepare the options and execute the request
        var
            $form = options.form ? $(options.form) : $el.closest('form'),
            $triggerEl = !!$form.length ? $form : $el,
            context = {handler: handler, options: options},
            loading = options.loading !== undefined && options.loading.length ? $(options.loading) : null,
            isRedirect = options.redirect !== undefined && options.redirect.length

        var _event = jQuery.Event('ajaxSetup')
        $triggerEl.trigger(_event, context)
        if (_event.isDefaultPrevented()) return

        if ($.type(loading) == 'string') loading = $(loading)

        var requestData,
            inputName,
            submitForm = !!options.submit,
            data = {}

        $.each($el.parents('[data-request-data]').toArray().reverse(), function extendRequest() {
            $.extend(data, stringToObj('data-request-data', $(this).data('request-data')))
        })

        if ($el.is(':input') && !$form.length) {
            inputName = $el.attr('name')
            if (inputName !== undefined && options.data[inputName] === undefined) {
                options.data[inputName] = $el.val()
            }
        }

        if (options.data !== undefined && !$.isEmptyObject(options.data)) {
            $.extend(data, options.data)
        }

        if (submitForm) {
            data['_handler'] = handler
            $form.append(appendObjToForm(data, $form))
        } else {
            requestData = [$form.serialize(), $.param(data)].filter(Boolean).join('&')
        }

        var requestOptions = {
            context: context,
            headers: {
                'X-IGNITER-REQUEST-HANDLER': handler,
            },
            success: function (data, textStatus, jqXHR) {
                // Stop beforeUpdate() OR data-request-before-update returns false
                if (this.options.beforeUpdate.apply(this, [data, textStatus, jqXHR]) === false) return
                if (options.fireBeforeUpdate && eval('(function($el, context, data, textStatus, jqXHR) {'+
                    options.fireBeforeUpdate+'}.call($el.get(0), $el, context, data, textStatus, jqXHR))') === false) return

                // Trigger 'ajaxBeforeUpdate' on the form, stop if event.preventDefault() is called
                var _event = jQuery.Event('ajaxBeforeUpdate')
                $triggerEl.trigger(_event, [context, data, textStatus, jqXHR])
                if (_event.isDefaultPrevented()) return

                // Proceed with the update process
                var updatePromise = requestOptions.handleUpdateResponse(data, textStatus, jqXHR)

                updatePromise.done(function () {
                    $triggerEl.trigger('ajaxSuccess', [context, data, textStatus, jqXHR])
                    options.fireSuccess && eval('(function($el, context, data, textStatus, jqXHR) {'+options.fireSuccess+'}.call($el.get(0), $el, context, data, textStatus, jqXHR))')
                })

                return updatePromise
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var errorMsg,
                    updatePromise = $.Deferred()

                if (errorThrown == 'abort')
                    return

                isRedirect = false
                options.redirect = null

                if (jqXHR.status == 406 && jqXHR.responseJSON) {
                    errorMsg = jqXHR.responseJSON['X_IGNITER_ERROR_MESSAGE']
                    updatePromise = requestOptions.handleUpdateResponse(jqXHR.responseJSON, textStatus, jqXHR)
                } else {
                    errorMsg = jqXHR.responseText ? jqXHR.responseText : jqXHR.statusText
                    updatePromise.resolve()
                }

                updatePromise.done(function () {
                    var _event = jQuery.Event('ajaxError')
                    $triggerEl.trigger(_event, [context, textStatus, jqXHR])
                    if (_event.isDefaultPrevented()) return

                    // Stop here if the data-request-error attribute returns false
                    if (options.fireError && eval('(function($el, context, textStatus, jqXHR) {'+options.fireError+'}.call($el.get(0), $el, context, textStatus, jqXHR))') === false)
                        return

                    requestOptions.handleErrorMessage(errorMsg)
                })

                return updatePromise

            },
            complete: function (data, textStatus, jqXHR) {
                $triggerEl.trigger('ajaxComplete', [context, data, textStatus, jqXHR])
                options.fireComplete && eval('(function($el, context, data, textStatus, jqXHR) {'+options.fireComplete+'}.call($el.get(0), $el, context, data, textStatus, jqXHR))')
            },

            // Custom function, requests confirmation from the user
            handleConfirmMessage: function (message) {
                var _event = jQuery.Event('ajaxConfirmMessage')

                _event.promise = $.Deferred()
                if ($(window).triggerHandler(_event, [message]) !== undefined) {
                    _event.promise.done(function () {
                        options.confirm = null
                        new Request(element, handler, options)
                    })
                    return false
                }

                if (_event.isDefaultPrevented()) return
                if (message) return confirm(message)
            },

            handleErrorMessage: function (message) {
                var _event = jQuery.Event('ajaxErrorMessage')
                $(window).trigger(_event, [message])
                if (_event.isDefaultPrevented()) return
                if (message) alert(message)
            },

            handleValidationMessage: function (message, fields) {
                $triggerEl.trigger('ajaxValidation', [context, message, fields])

                var isFirstInvalidField = true
                $.each(fields, function focusErrorField(fieldName, fieldMessages) {
                    fieldName = fieldName.replace(/\.(\w+)/g, '[$1]')

                    var fieldElement = $form.find('[name="'+fieldName+'"], [name="'+fieldName+'[]"], [name$="['+fieldName+']"], [name$="['+fieldName+'][]"]').filter(':enabled').first()
                    if (fieldElement.length > 0) {

                        var _event = jQuery.Event('ajaxInvalidField')
                        $(window).trigger(_event, [fieldElement.get(0), fieldName, fieldMessages, isFirstInvalidField])

                        if (isFirstInvalidField) {
                            if (!_event.isDefaultPrevented()) fieldElement.focus()
                            isFirstInvalidField = false
                        }
                    }
                })
            },

            // Custom function, redirect the browser to another location
            handleRedirectResponse: function (url) {
                window.location.href = url
            },

            // Custom function, handle any application specific response
            handleUpdateResponse: function (data, textStatus, jqXHR) {
                var updatePromise = $.Deferred().done(function () {
                    var dataArray = []
                    try {
                        dataArray = jQuery.type(data) === 'object' ? data : jQuery.parseJSON(data)
                    } catch (e) {
                    }

                    for (var partial in dataArray) {
                        var selector = partial
                        if (jQuery.type(selector) === 'string' && selector.charAt(0) == '@') {
                            $(selector.substring(1)).append(dataArray[partial]).trigger('ajaxUpdate', [context, data, textStatus, jqXHR])
                        } else if (jQuery.type(selector) == 'string' && selector.charAt(0) == '^') {
                            $(selector.substring(1)).prepend(dataArray[partial]).trigger('ajaxUpdate', [context, data, textStatus, jqXHR])
                        } else if (jQuery.type(selector) == 'string' && selector.charAt(0) == '~') {
                            $(selector.substring(1)).replaceWith(data[partial]).trigger('ajaxUpdate', [context, data, textStatus, jqXHR])
                        } else {
                            $(selector).trigger('ajaxBeforeReplace')
                            $(selector).html(dataArray[partial]).trigger('ajaxUpdate', [context, data, textStatus, jqXHR])
                        }
                    }

                    // Wait for .html() method to finish rendering from partial updates
                    setTimeout(function () {
                        $(window)
                            .trigger('ajaxUpdateComplete', [context, data, textStatus, jqXHR])
                            .trigger('resize')
                    }, 0)
                })

                // Handle redirect
                if (data['X_IGNITER_REDIRECT']) {
                    options.redirect = data['X_IGNITER_REDIRECT']
                    isRedirect = true
                }

                if (isRedirect)
                    requestOptions.handleRedirectResponse(options.redirect)

                if (data['X_IGNITER_ERROR_FIELDS'])
                    requestOptions.handleValidationMessage(data['X_IGNITER_ERROR_MESSAGE'], data['X_IGNITER_ERROR_FIELDS'])

                updatePromise.resolve()

                return updatePromise
            },
        }

        // Allow default business logic to be called from user functions
        context.success = requestOptions.success
        context.error = requestOptions.error
        context.complete = requestOptions.complete
        requestOptions = $.extend(requestOptions, options)
        requestOptions.data = requestData

        // Initiate request
        if (options.confirm && !requestOptions.handleConfirmMessage(options.confirm)) {
            return
        }

        if (loading) loading.show()

        if (submitForm) {
            $form.submit()
            return;
        }

        $(window).trigger('ajaxBeforeSend', [context])
        $el.trigger('ajaxPromise', [context])
        return $.ajax(requestOptions)
            .fail(function (jqXHR, textStatus, errorThrown) {
                if (!isRedirect) {
                    $el.trigger('ajaxFail', [context, textStatus, jqXHR])
                }
            })
            .done(function (data, textStatus, jqXHR) {
                if (!isRedirect) {
                    $el.trigger('ajaxDone', [context, data, textStatus, jqXHR])
                }

                if (loading) loading.hide()
            })
            .always(function (dataOrXhr, textStatus, xhrOrError) {
                $el.trigger('ajaxAlways', [context, dataOrXhr, textStatus, xhrOrError])
            })
    }

    Request.DEFAULTS = {
        type: 'POST',
        update: {},
        beforeUpdate: function (data, textStatus, jqXHR) {
        },
        fireBeforeUpdate: null,
        fireSuccess: null,
        fireError: null,
        fireComplete: null
    }

    // REQUEST PLUGIN DEFINITION
    // ============================

    var old = $.fn.request

    $.fn.request = function (handler, option) {
        var $this = $(this).first()
        var data = {
            fireBeforeUpdate: $this.data('request-before-update'),
            fireSuccess: $this.data('request-success'),
            fireError: $this.data('request-error'),
            fireComplete: $this.data('request-complete'),
            confirm: $this.data('request-confirm'),
            redirect: $this.data('request-redirect'),
            loading: $this.data('request-loading'),
            submit: $this.data('request-submit'),
            form: $this.data('request-form'),
            update: stringToObj('data-request-update', $this.data('request-update')),
            data: stringToObj('data-request-data', $this.data('request-data'))
        }
        if (!handler) handler = $this.data('request')
        var options = $.extend(true, {}, Request.DEFAULTS, data, typeof option == 'object' && option)
        return new Request($this, handler, options)
    }

    $.fn.request.Constructor = Request

    $.request = function (handler, option) {
        return $('<form />').request(handler, option)
    }

    // REQUEST NO CONFLICT
    // =================

    $.fn.request.noConflict = function () {
        $.fn.request = old
        return this
    }

    // REQUEST DATA-API
    // ==============

    $(document).on('submit', '[data-request]', function () {
        $(this).request()
        return false
    })

    $(document).on('change', 'select[data-request]', function () {
        $(this).request()
        return false
    })

    $(document).on('click', 'a[data-request], button[data-request]', function (e) {
        e.preventDefault()
        $(this).request()
        if ($(this).is('[type=submit]'))
            return false
    })

    function stringToObj(name, value) {
        if (value === undefined) value = ''
        if (typeof value == 'object') return value

        try {
            return JSON.parse(JSON.stringify(eval("({"+value+"})")))
        } catch (e) {
            throw new Error('Error parsing the '+name+' attribute value. '+e)
        }
    }

    function appendObjToForm(objToAppend, $appendToForm) {
        $.each(objToAppend, function (key, value) {
            var input = $("<input>").attr({
                'type': 'hidden',
                'name': key
            }).val(value)

            $appendToForm.append(input)
        })
    }
}(window.jQuery);

/*
 * The loading indicator.
 *
 * Displays the animated loading indicator at the top of the page.
 *
 * JavaScript API:
 * $.ti.loadingIndicator.show()
 * $.ti.loadingIndicator.hide()
 *
 * By default if the show() method has been called several times, the hide() method should be
 * called the same number of times in order to hide the card. Use hide(true) to hide the
 * indicator forcibly.
 */
+function ($) {
    "use strict"

    if ($.ti === undefined)
        $.ti = {}

    const LOADER_CLASS = 'ti-loading',
        LOADER_MARGIN = 12.5,
        LOADER_LEFT_MARGIN = LOADER_MARGIN / 100,
        LOADER_RIGHT_MARGIN = 1-LOADER_LEFT_MARGIN;


    var LoadingIndicator = function () {
        var self = this
        this.timeout = undefined
        this.counter = 0
        this.progress = 0
        this.indicator = $('<div/>').addClass('bar-loading-indicator loaded')
            .append($('<div />').addClass('bar'))
            .append($('<div />').addClass('bar-loaded'))
        this.bar = this.indicator.find('.bar')
        this.bar.html('<div class="peg"></div>')

        $(document).ready(function () {
            $(document.body).append(self.indicator)
        })
    }

    LoadingIndicator.barTemplate = [
        '<div class="bar" role="bar">',
        '<div class="peg"></div>',
        '</div>',
    ].join('\n')

    LoadingIndicator.prototype.show = function () {
        this.counter++

        // Restart the animation
        this.bar.after(this.bar = this.bar.clone()).remove()

        if (this.counter > 1)
            return

        this.progress = LOADER_LEFT_MARGIN
        this.indicator.removeClass('loaded')
        $(document.body).addClass('ti-loading')

        this.bar.animate({translateX: '0%'}, 0)

        var self = this
        setTimeout(function () {
            self.animate()
            self.trickle()
        }, 0)
    }

    LoadingIndicator.prototype.hide = function (force) {
        this.counter--
        if (force !== undefined && force)
            this.counter = 0

        if (this.counter <= 0) {
            this.indicator.addClass('loaded')
            $(document.body).removeClass('ti-loading')
        }
    }

    LoadingIndicator.prototype.animate = function () {
        this.indicator.animate({translateX: this.progress * 100+'%'}, 200)
    }

    LoadingIndicator.prototype.clear = function () {
        if (this.timeout) clearTimeout(this.timeout)
        this.timeout = undefined
    }

    LoadingIndicator.prototype.trickle = function () {
        var self = this
        this.timeout = setTimeout(function () {
            self.increment((LOADER_RIGHT_MARGIN-self.progress) * .035 * Math.random())
            self.trickle()
        }, 350+(400 * Math.random()))
    }

    LoadingIndicator.prototype.increment = function (amount) {
        if (this.progress < LOADER_RIGHT_MARGIN) this.progress += amount || .05
        this.animate()
    }

    $.ti.loadingIndicator = new LoadingIndicator()

    // BAR LOAD INDICATOR DATA-API
    // ==============

    $(document)
        .on('ajaxPromise', '[data-request]', function (event) {
            // Prevent this event from bubbling up to a non-related data-request
            // element, for example a <form> tag wrapping a <button> tag
            event.stopPropagation()

            $.ti.loadingIndicator.show()

            // This code will cover instances where the element has been removed
            // from the DOM, making the resolution event below an orphan.
            var $el = $(this)
            $(window).one('ajaxUpdateComplete', function () {
                if ($el.closest('html').length === 0)
                    $.ti.loadingIndicator.hide()
            })
        })
        .on('ajaxFail ajaxDone', '[data-request]', function (event) {
            event.stopPropagation()
            $.ti.loadingIndicator.hide()
        })

    // BUTTON LOAD INDICATOR DATA-API
    // ==============

    $(document)
        .on('ajaxPromise', '[data-request]', function () {
            var $target = $(this)

            if ($target.data('attach-loading') !== undefined) {
                attachLoadingToggleClass($target, true)
            }

            if ($target.is('form')) {
                attachLoadingToggleClass($('[data-attach-loading]', $target), true)
                replaceLoadingToggleClass($('[data-replace-loading]', $target), true)
            }

            if ($target.data('replace-loading') !== undefined) {
                replaceLoadingToggleClass($target, true)
            }
        })
        .on('ajaxFail ajaxDone', '[data-request]', function () {
            var $target = $(this)

            if ($target.data('attach-loading') !== undefined) {
                attachLoadingToggleClass($target, false)
            }

            if ($target.is('form')) {
                attachLoadingToggleClass($('[data-attach-loading]', $target), false)
                replaceLoadingToggleClass($('[data-replace-loading]', $target), false)
            }

            if ($target.data('replace-loading') !== undefined) {
                replaceLoadingToggleClass($target, false)
            }
        })

    function attachLoadingToggleClass($el, show) {
        if (!$el || !$el.length)
            return;

        var loaderClass = $el.data('attach-loading').length ? $el.data('attach-loading') : LOADER_CLASS

        if (show === true) {
            $el.addClass(loaderClass)
                .prop('disabled', true)
        } else {
            $el.removeClass(loaderClass)
                .prop('disabled', false)
        }
    }

    function replaceLoadingToggleClass($el, show) {
        if (!$el || !$el.length)
            return;

        var loaderClass = $el.data('replace-loading').length ? $el.data('replace-loading') : LOADER_CLASS

        if (show === true) {
            $el.children().wrapAll('<div class="replace-loading-bk d-none"></div>')
            $el.find('.replace-loading-bk').before('<i class="replace-loading '+loaderClass+'"></i>')
            $el.prop('disabled', true)
        } else {
            $el.find('.replace-loading').remove()
            $el.find('.replace-loading-bk').children().unwrap()
            $el.prop('disabled', false)
        }
    }
}(window.jQuery);
/*
 * The progress indicator.
 *
 * data-progress-indicator="Message" - displays a progress indicator with a supplied message, the element
 * must be wrapped in a `<div class="progress-indicator-container"></div>` container.
 *
 * JavaScript API:
 *
 * $('#buttons').progressIndicator({ text: 'Saving...', opaque: true }) - display the indicator in a solid (opaque) state
 * $('#buttons').progressIndicator({ centered: true }) - display the indicator aligned in the center horizontally
 * $('#buttons').progressIndicator({ size: small }) - display the indicator in small size
 * $('#buttons').progressIndicator({ text: 'Saving...' }) - display the indicator in a transparent state
 * $('#buttons').progressIndicator('hide') - hide the indicator
 */
+function ($) {
    "use strict"

    var ProgressIndicator = function (element, options) {
        this.$el = $(element)

        this.options = options || {}
        this.counter = 0
        this.show()
    }

    ProgressIndicator.prototype.hide = function () {
        this.counter--

        if (this.counter <= 0) {
            $('div.progress-indicator', this.$el).remove()
            this.$el.removeClass('in-progress')
        }
    }

    ProgressIndicator.prototype.show = function (options) {
        if (options)
            this.options = options

        this.hide()

        var indicator = $('<div class="progress-indicator"></div>')
        indicator.append($('<span class="ti-loading"></span>'))
        indicator.append($('<div></div>').text(this.options.text))
        if (this.options.opaque !== undefined) {
            indicator.addClass('is-opaque')
        }
        if (this.options.centered !== undefined) {
            indicator.addClass('indicator-center')
        }
        if (this.options.size === 'small') {
            indicator.addClass('size-small')
        }

        this.$el.prepend(indicator)
        this.$el.addClass('in-progress')

        this.counter++
    }

    ProgressIndicator.prototype.destroy = function () {
        this.$el.removeData('ti.progressIndicator')
        this.$el = null
    }

    ProgressIndicator.DEFAULTS = {
        text: ''
    }

    // PROGRESS INDICATOR PLUGIN DEFINITION
    // ============================

    var old = $.fn.progressIndicator

    $.fn.progressIndicator = function (option) {
        var args = arguments;

        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.progressIndicator')
            var options = $.extend({}, ProgressIndicator.DEFAULTS, typeof option == 'object' && option)

            if (!data) {
                if (typeof option == 'string')
                    return;

                $this.data('ti.progressIndicator', new ProgressIndicator(this, options))
            } else {
                if (typeof option !== 'string')
                    data.show(options);
                else {
                    var methodArgs = [];
                    for (var i = 1; i < args.length; i++)
                        methodArgs.push(args[i])

                    data[option].apply(data, methodArgs)
                }
            }
        })
    }

    $.fn.progressIndicator.Constructor = ProgressIndicator

    // PROGRESS INDICATOR NO CONFLICT
    // =================

    $.fn.progressIndicator.noConflict = function () {
        $.fn.progressIndicator = old
        return this
    }

    // PROGRESS INDICATOR DATA-API
    // ==============

    $(document)
        .on('ajaxPromise', '[data-progress-indicator]', function () {
            var
                $indicatorContainer = $(this).closest('.progress-indicator-container'),
                progressText = $(this).data('progress-indicator'),
                options = {
                    opaque: $(this).data('progress-indicator-opaque'),
                    centered: $(this).data('progress-indicator-centered'),
                    size: $(this).data('progress-indicator-size')
                }

            if (progressText)
                options.text = progressText

            $indicatorContainer.progressIndicator(options)
        })
        .on('ajaxFail ajaxDone', '[data-progress-indicator]', function () {
            $(this).closest('.progress-indicator-container').progressIndicator('hide')
        })
}(window.jQuery);
/* ========================================================================
 * TastyIgniter: flashmessage.js v2.2.0
 * https://tastyigniter.com/docs/javascript
 * ======================================================================== */
+function ($) {
    "use strict"

    var FlashMessage = function (options, el) {
        var options = $.extend({}, FlashMessage.DEFAULTS, options),
            $element = $(el)

        $('body > p.flash-message').remove()

        if ($element.length === 0) {
            $element = $('<div />', {
                class: 'alert alert-'+options.class
            }).html(options.text)
        }

        $element.addClass('flash-message animated fadeInDown')
        $element.attr('data-control', null)

        if (options.allowDismiss)
            $element.prepend('<button type="button" class="close" aria-hidden="true">&times;</button>')

        $element.on('click', 'button', remove)
        if (options.interval > 0) $element.on('click', remove)

        $(options.container).prepend($element)

        var timer = null

        setTimeout(function () {
            $element.addClass('show')
        }, 100)

        if (options.allowDismiss && options.interval > 0)
            timer = window.setTimeout(remove, options.interval * 1000)

        function removeElement() {
            $element.remove()
        }

        function remove() {
            window.clearInterval(timer)

            $element.addClass('fadeOutUp')
            $.support.transition && $element.hasClass('fadeOutUp')
                ? $element
                .one($.support.transition.end, removeElement)
                .emulateTransitionEnd(500)
                : removeElement()
        }
    }

    FlashMessage.DEFAULTS = {
        container: '#notification',
        class: 'success',
        text: 'text',
        interval: 5,
        allowDismiss: true,
    }

    // FLASH MESSAGE PLUGIN DEFINITION
    // ============================

    if ($.ti === undefined)
        $.ti = {}

    $.ti.flashMessage = FlashMessage

    // FLASH MESSAGE DATA-API
    // ===============

    $(document).render(function () {
        $('[data-control="flash-message"]').each(function (index, element) {
            setTimeout(function () {
                $.ti.flashMessage($(element).data(), element)
            }, (index+1) * 500)
        })

        $('[data-control="flash-overlay"]').each(function (index, element) {
            var $this = $(element),
                options = $.extend({}, $this.data(), $this.data('closeOnEsc') === true ? {
                    timer: (index+1) * 3000
                } : {})
            swal(options)
        })
    })

    $(document).on('ajaxValidation', '[data-request][data-request-validate]', function (event, context, errorMsg, fields) {
        var $this = $(this).closest('form'),
            $container = $('[data-validate-error]', $this),
            messages = [],
            $field

        $.each(fields, function (fieldName, fieldMessages) {
            $field = $('[data-validate-for="'+fieldName+'"]', $this)
            messages = $.merge(messages, fieldMessages)
            if (!!$field.length) {
                if (!$field.text().length || $field.data('emptyMode') == true) {
                    $field
                        .data('emptyMode', true)
                        .text(fieldMessages.join(', '))
                }
                $field.addClass('visible')
            }
        })

        if (!!$container.length) {
            $container = $('[data-validate-error]', $this)
        }

        if (!!$container.length) {
            var $oldMessages = $('[data-message]', $container)
            $container.addClass('visible')

            if (!!$oldMessages.length) {
                var $clone = $oldMessages.first()

                $.each(messages, function (key, message) {
                    $clone.clone().text(message).insertAfter($clone)
                })

                $oldMessages.remove()
            } else {
                $container.text(errorMsg)
            }
        }

        $this.one('ajaxError', function (event) {
            event.preventDefault()
        })
    })

    $(document).on('ajaxPromise', '[data-request][data-request-validate]', function () {
        var $this = $(this).closest('form')
        $('[data-validate-for]', $this).removeClass('visible')
        $('[data-validate-error]', $this).removeClass('visible')
    })

}(window.jQuery)

+function ($) {
    "use strict";

    // TOGGLE CLASS DEFINITION
    // ============================

    var Toggler = function (element, options) {
        this.options = options
        this.$el = $(element)

        this.$el.on('click', $.proxy(this.onClicked, this))

        if (this.options.disabled)
            this.$el.attr('readonly', true)
    }

    Toggler.DEFAULTS = {
        disabled: true
    }

    Toggler.prototype.onClicked = function (event) {
        var $element = $(event.target)

        if ($element.attr('readonly'))
            this.$el.attr('readonly', false)
    }

    // TOGGLE PLUGIN DEFINITION
    // ============================

    var old = $.fn.toggler

    $.fn.toggler = function (option) {
        var args = Array.prototype.slice.call(arguments, 1), result
        this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.toggler')
            var options = $.extend({}, Toggler.DEFAULTS, $this.data(), typeof option == 'object' && option)
            if (!data) $this.data('ti.toggler', (data = new Toggler(this, options)))
            if (typeof option == 'string') result = data[option].apply(data, args)
            if (typeof result != 'undefined') return false
        })

        return result ? result : this
    }

    $.fn.toggler.Constructor = Toggler

    // TOGGLE NO CONFLICT
    // =================

    $.fn.toggler.noConflict = function () {
        $.fn.toggler = old
        return this
    }

    // TOGGLE DATA-API
    // ===============
    $(document).render(function () {
        $('[data-toggle="disabled"]').toggler()
    })

}(window.jQuery);

/*
 * The trigger API
 */
+function ($) {
    "use strict";

    var TriggerOn = function (element, options) {

        var $el = this.$el = $(element);

        this.options = options || {};

        if (this.options.triggerCondition === false)
            throw new Error('Trigger condition is not specified.')

        if (this.options.trigger === false)
            throw new Error('Trigger selector is not specified.')

        if (this.options.triggerAction === false)
            throw new Error('Trigger action is not specified.')

        this.triggerCondition = this.options.triggerCondition

        if (this.options.triggerCondition.indexOf('value') == 0) {
            var match = this.options.triggerCondition.match(/[^[\]]+(?=])/g)
            this.triggerCondition = 'value'
            this.triggerConditionValue = (match) ? match : [""]
        }

        this.triggerParent = this.options.triggerClosestParent !== undefined
            ? $el.closest(this.options.triggerClosestParent)
            : undefined

        if (
            this.triggerCondition == 'checked' ||
            this.triggerCondition == 'unchecked' ||
            this.triggerCondition == 'value'
        ) {
            $(document).on('change', this.options.trigger, $.proxy(this.onConditionChanged, this))
        }

        var self = this
        $el.on('ti.triggerOn.update', function (e) {
            e.stopPropagation()
            self.onConditionChanged()
        })

        self.onConditionChanged()
    }

    TriggerOn.prototype.onConditionChanged = function () {
        if (this.triggerCondition == 'checked') {
            this.updateTarget(!!$(this.options.trigger+':checked', this.triggerParent).length)
        } else if (this.triggerCondition == 'unchecked') {
            this.updateTarget(!$(this.options.trigger+':checked', this.triggerParent).length)
        } else if (this.triggerCondition == 'value') {
            var trigger, triggerValue = ''

            trigger = $(this.options.trigger, this.triggerParent)
                .not('input[type=checkbox], input[type=radio], input[type=button], input[type=submit]')

            if (!trigger.length) {
                trigger = $(this.options.trigger, this.triggerParent)
                    .not(':not(input[type=checkbox]:checked, input[type=radio]:checked)')
            }

            if (!!trigger.length) {
                triggerValue = trigger.val()
            }

            this.updateTarget($.inArray(triggerValue, this.triggerConditionValue) != -1)
        }
    }

    TriggerOn.prototype.updateTarget = function (status) {
        var self = this,
            actions = this.options.triggerAction.split('|')

        $.each(actions, function (index, action) {
            self.updateTargetAction(action, status)
        })

        $(window).trigger('resize')

        this.$el.trigger('ti.triggerOn.afterUpdate', status)
    }

    TriggerOn.prototype.updateTargetAction = function (action, status) {
        if (action == 'show') {
            this.$el
                .toggleClass('animated fadeIn', status)
                .toggleClass('hide', !status)
                .trigger('hide.ti.triggerapi', [!status])
        } else if (action == 'hide') {
            this.$el
                .toggleClass('animated fadeIn', !status)
                .toggleClass('hide', status)
                .trigger('hide.ti.triggerapi', [status])
        } else if (action == 'enable') {
            this.$el
                .prop('disabled', !status)
                .toggleClass('control-disabled', !status)
                .trigger('disable.ti.triggerapi', [!status])
        } else if (action == 'disable') {
            this.$el
                .prop('disabled', status)
                .toggleClass('control-disabled', status)
                .trigger('disable.ti.triggerapi', [status])
        } else if (action == 'check' && status) {
            this.$el
                .filter('input[type=checkbox]')
                .prop('checked', true);
        } else if (action == 'empty' && status) {
            this.$el
                .not('input[type=checkbox], input[type=radio], input[type=button], input[type=submit]')
                .val('')

            this.$el
                .not(':not(input[type=checkbox], input[type=radio])')
                .prop('checked', false)

            this.$el
                .trigger('empty.ti.triggerapi')
                .trigger('change')
        }

        if (action == 'show' || action == 'hide') {
            this.fixButtonClasses()
        }
    }

    TriggerOn.prototype.fixButtonClasses = function () {
        var group = this.$el.closest('.btn-group')

        if (group.length > 0 && this.$el.is(':last-child'))
            this.$el.prev().toggleClass('last', this.$el.hasClass('hide'))
    }

    TriggerOn.DEFAULTS = {
        triggerAction: false,
        triggerCondition: false,
        triggerClosestParent: undefined,
        trigger: false
    }

    // TRIGGERON PLUGIN DEFINITION
    // ============================

    var old = $.fn.triggerOn

    $.fn.triggerOn = function (option) {
        return this.each(function () {
            var $this = $(this)
            var data = $this.data('ti.triggerOn')
            var options = $.extend({}, TriggerOn.DEFAULTS, $this.data(), typeof option == 'object' && option)

            if (!data) $this.data('ti.triggerOn', (data = new TriggerOn(this, options)))
        })
    }

    $.fn.triggerOn.Constructor = TriggerOn

    // TRIGGERON NO CONFLICT
    // =================

    $.fn.triggerOn.noConflict = function () {
        $.fn.triggerOn = old
        return this
    }

    // TRIGGERON DATA-API
    // ===============

    $(document).render(function () {
        $('[data-trigger]').triggerOn()
    })

}(window.jQuery);

/*! Select2 4.1.0-rc.0 | https://github.com/select2/select2/blob/master/LICENSE.md */
!function (n) {
    "function" == typeof define && define.amd ? define(["jquery"], n) : "object" == typeof module && module.exports ? module.exports = function (e, t) {
        return void 0 === t && (t = "undefined" != typeof window ? require("jquery") : require("jquery")(e)), n(t), t
    } : n(jQuery)
}(function (t) {
    var e, n, s, p, r, o, h, f, g, m, y, v, i, a, _,
        s = ((u = t && t.fn && t.fn.select2 && t.fn.select2.amd ? t.fn.select2.amd : u) && u.requirejs || (u ? n = u : u = {}, g = {}, m = {}, y = {}, v = {}, i = Object.prototype.hasOwnProperty, a = [].slice, _ = /\.js$/, h = function (e, t) {
            var n, s, i = c(e), r = i[0], t = t[1];
            return e = i[1], r && (n = x(r = l(r, t))), r ? e = n && n.normalize ? n.normalize(e, (s = t, function (e) {
                return l(e, s)
            })) : l(e, t) : (r = (i = c(e = l(e, t)))[0], e = i[1], r && (n = x(r))), {
                f: r ? r+"!"+e : e,
                n: e,
                pr: r,
                p: n
            }
        }, f = {
            require: function (e) {
                return w(e)
            }, exports: function (e) {
                var t = g[e];
                return void 0 !== t ? t : g[e] = {}
            }, module: function (e) {
                return {
                    id: e, uri: "", exports: g[e], config: (t = e, function () {
                        return y && y.config && y.config[t] || {}
                    })
                };
                var t
            }
        }, r = function (e, t, n, s) {
            var i, r, o, a, l, c = [], u = typeof n, d = A(s = s || e);
            if ("undefined" == u || "function" == u) {
                for (t = !t.length && n.length ? ["require", "exports", "module"] : t, a = 0; a < t.length; a += 1) if ("require" === (r = (o = h(t[a], d)).f)) c[a] = f.require(e); else if ("exports" === r) c[a] = f.exports(e), l = !0; else if ("module" === r) i = c[a] = f.module(e); else if (b(g, r) || b(m, r) || b(v, r)) c[a] = x(r); else {
                    if (!o.p) throw new Error(e+" missing "+r);
                    o.p.load(o.n, w(s, !0), function (t) {
                        return function (e) {
                            g[t] = e
                        }
                    }(r), {}), c[a] = g[r]
                }
                u = n ? n.apply(g[e], c) : void 0, e && (i && i.exports !== p && i.exports !== g[e] ? g[e] = i.exports : u === p && l || (g[e] = u))
            } else e && (g[e] = n)
        }, e = n = o = function (e, t, n, s, i) {
            if ("string" == typeof e) return f[e] ? f[e](t) : x(h(e, A(t)).f);
            if (!e.splice) {
                if ((y = e).deps && o(y.deps, y.callback), !t) return;
                t.splice ? (e = t, t = n, n = null) : e = p
            }
            return t = t || function () {
            }, "function" == typeof n && (n = s, s = i), s ? r(p, e, t, n) : setTimeout(function () {
                r(p, e, t, n)
            }, 4), o
        }, o.config = function (e) {
            return o(e)
        }, e._defined = g, (s = function (e, t, n) {
            if ("string" != typeof e) throw new Error("See almond README: incorrect module build, no module name");
            t.splice || (n = t, t = []), b(g, e) || b(m, e) || (m[e] = [e, t, n])
        }).amd = {jQuery: !0}, u.requirejs = e, u.require = n, u.define = s), u.define("almond", function () {
        }), u.define("jquery", [], function () {
            var e = t || $;
            return null == e && console && console.error && console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."), e
        }), u.define("select2/utils", ["jquery"], function (r) {
            var s = {};

            function c(e) {
                var t, n = e.prototype, s = [];
                for (t in n) "function" == typeof n[t] && "constructor" !== t && s.push(t);
                return s
            }

            s.Extend = function (e, t) {
                var n, s = {}.hasOwnProperty;

                function i() {
                    this.constructor = e
                }

                for (n in t) s.call(t, n) && (e[n] = t[n]);
                return i.prototype = t.prototype, e.prototype = new i, e.__super__ = t.prototype, e
            }, s.Decorate = function (s, i) {
                var e = c(i), t = c(s);

                function r() {
                    var e = Array.prototype.unshift, t = i.prototype.constructor.length, n = s.prototype.constructor;
                    0 < t && (e.call(arguments, s.prototype.constructor), n = i.prototype.constructor), n.apply(this, arguments)
                }

                i.displayName = s.displayName, r.prototype = new function () {
                    this.constructor = r
                };
                for (var n = 0; n < t.length; n++) {
                    var o = t[n];
                    r.prototype[o] = s.prototype[o]
                }
                for (var a = 0; a < e.length; a++) {
                    var l = e[a];
                    r.prototype[l] = function (e) {
                        var t = function () {
                        };
                        e in r.prototype && (t = r.prototype[e]);
                        var n = i.prototype[e];
                        return function () {
                            return Array.prototype.unshift.call(arguments, t), n.apply(this, arguments)
                        }
                    }(l)
                }
                return r
            };

            function e() {
                this.listeners = {}
            }

            e.prototype.on = function (e, t) {
                this.listeners = this.listeners || {}, e in this.listeners ? this.listeners[e].push(t) : this.listeners[e] = [t]
            }, e.prototype.trigger = function (e) {
                var t = Array.prototype.slice, n = t.call(arguments, 1);
                this.listeners = this.listeners || {}, 0 === (n = null == n ? [] : n).length && n.push({}), (n[0]._type = e) in this.listeners && this.invoke(this.listeners[e], t.call(arguments, 1)), "*" in this.listeners && this.invoke(this.listeners["*"], arguments)
            }, e.prototype.invoke = function (e, t) {
                for (var n = 0, s = e.length; n < s; n++) e[n].apply(this, t)
            }, s.Observable = e, s.generateChars = function (e) {
                for (var t = "", n = 0; n < e; n++) t += Math.floor(36 * Math.random()).toString(36);
                return t
            }, s.bind = function (e, t) {
                return function () {
                    e.apply(t, arguments)
                }
            }, s._convertData = function (e) {
                for (var t in e) {
                    var n = t.split("-"), s = e;
                    if (1 !== n.length) {
                        for (var i = 0; i < n.length; i++) {
                            var r = n[i];
                            (r = r.substring(0, 1).toLowerCase()+r.substring(1)) in s || (s[r] = {}), i == n.length-1 && (s[r] = e[t]), s = s[r]
                        }
                        delete e[t]
                    }
                }
                return e
            }, s.hasScroll = function (e, t) {
                var n = r(t), s = t.style.overflowX, i = t.style.overflowY;
                return (s !== i || "hidden" !== i && "visible" !== i) && ("scroll" === s || "scroll" === i || (n.innerHeight() < t.scrollHeight || n.innerWidth() < t.scrollWidth))
            }, s.escapeMarkup = function (e) {
                var t = {
                    "\\": "&#92;",
                    "&": "&amp;",
                    "<": "&lt;",
                    ">": "&gt;",
                    '"': "&quot;",
                    "'": "&#39;",
                    "/": "&#47;"
                };
                return "string" != typeof e ? e : String(e).replace(/[&<>"'\/\\]/g, function (e) {
                    return t[e]
                })
            }, s.__cache = {};
            var n = 0;
            return s.GetUniqueElementId = function (e) {
                var t = e.getAttribute("data-select2-id");
                return null != t || (t = e.id ? "select2-data-"+e.id : "select2-data-"+(++n).toString()+"-"+s.generateChars(4), e.setAttribute("data-select2-id", t)), t
            }, s.StoreData = function (e, t, n) {
                e = s.GetUniqueElementId(e);
                s.__cache[e] || (s.__cache[e] = {}), s.__cache[e][t] = n
            }, s.GetData = function (e, t) {
                var n = s.GetUniqueElementId(e);
                return t ? s.__cache[n] && null != s.__cache[n][t] ? s.__cache[n][t] : r(e).data(t) : s.__cache[n]
            }, s.RemoveData = function (e) {
                var t = s.GetUniqueElementId(e);
                null != s.__cache[t] && delete s.__cache[t], e.removeAttribute("data-select2-id")
            }, s.copyNonInternalCssClasses = function (e, t) {
                var n = (n = e.getAttribute("class").trim().split(/\s+/)).filter(function (e) {
                    return 0 === e.indexOf("select2-")
                }), t = (t = t.getAttribute("class").trim().split(/\s+/)).filter(function (e) {
                    return 0 !== e.indexOf("select2-")
                }), t = n.concat(t);
                e.setAttribute("class", t.join(" "))
            }, s
        }), u.define("select2/results", ["jquery", "./utils"], function (d, p) {
            function s(e, t, n) {
                this.$element = e, this.data = n, this.options = t, s.__super__.constructor.call(this)
            }

            return p.Extend(s, p.Observable), s.prototype.render = function () {
                var e = d('<ul class="select2-results__options" role="listbox"></ul>');
                return this.options.get("multiple") && e.attr("aria-multiselectable", "true"), this.$results = e
            }, s.prototype.clear = function () {
                this.$results.empty()
            }, s.prototype.displayMessage = function (e) {
                var t = this.options.get("escapeMarkup");
                this.clear(), this.hideLoading();
                var n = d('<li role="alert" aria-live="assertive" class="select2-results__option"></li>'),
                    s = this.options.get("translations").get(e.message);
                n.append(t(s(e.args))), n[0].className += " select2-results__message", this.$results.append(n)
            }, s.prototype.hideMessages = function () {
                this.$results.find(".select2-results__message").remove()
            }, s.prototype.append = function (e) {
                this.hideLoading();
                var t = [];
                if (null != e.results && 0 !== e.results.length) {
                    e.results = this.sort(e.results);
                    for (var n = 0; n < e.results.length; n++) {
                        var s = e.results[n], s = this.option(s);
                        t.push(s)
                    }
                    this.$results.append(t)
                } else 0 === this.$results.children().length && this.trigger("results:message", {message: "noResults"})
            }, s.prototype.position = function (e, t) {
                t.find(".select2-results").append(e)
            }, s.prototype.sort = function (e) {
                return this.options.get("sorter")(e)
            }, s.prototype.highlightFirstItem = function () {
                var e = this.$results.find(".select2-results__option--selectable"),
                    t = e.filter(".select2-results__option--selected");
                (0 < t.length ? t : e).first().trigger("mouseenter"), this.ensureHighlightVisible()
            }, s.prototype.setClasses = function () {
                var t = this;
                this.data.current(function (e) {
                    var s = e.map(function (e) {
                        return e.id.toString()
                    });
                    t.$results.find(".select2-results__option--selectable").each(function () {
                        var e = d(this), t = p.GetData(this, "data"), n = ""+t.id;
                        null != t.element && t.element.selected || null == t.element && -1 < s.indexOf(n) ? (this.classList.add("select2-results__option--selected"), e.attr("aria-selected", "true")) : (this.classList.remove("select2-results__option--selected"), e.attr("aria-selected", "false"))
                    })
                })
            }, s.prototype.showLoading = function (e) {
                this.hideLoading();
                e = {
                    disabled: !0,
                    loading: !0,
                    text: this.options.get("translations").get("searching")(e)
                }, e = this.option(e);
                e.className += " loading-results", this.$results.prepend(e)
            }, s.prototype.hideLoading = function () {
                this.$results.find(".loading-results").remove()
            }, s.prototype.option = function (e) {
                var t = document.createElement("li");
                t.classList.add("select2-results__option"), t.classList.add("select2-results__option--selectable");
                var n, s = {role: "option"},
                    i = window.Element.prototype.matches || window.Element.prototype.msMatchesSelector || window.Element.prototype.webkitMatchesSelector;
                for (n in (null != e.element && i.call(e.element, ":disabled") || null == e.element && e.disabled) && (s["aria-disabled"] = "true", t.classList.remove("select2-results__option--selectable"), t.classList.add("select2-results__option--disabled")), null == e.id && t.classList.remove("select2-results__option--selectable"), null != e._resultId && (t.id = e._resultId), e.title && (t.title = e.title), e.children && (s.role = "group", s["aria-label"] = e.text, t.classList.remove("select2-results__option--selectable"), t.classList.add("select2-results__option--group")), s) {
                    var r = s[n];
                    t.setAttribute(n, r)
                }
                if (e.children) {
                    var o = d(t), a = document.createElement("strong");
                    a.className = "select2-results__group", this.template(e, a);
                    for (var l = [], c = 0; c < e.children.length; c++) {
                        var u = e.children[c], u = this.option(u);
                        l.push(u)
                    }
                    i = d("<ul></ul>", {
                        class: "select2-results__options select2-results__options--nested",
                        role: "none"
                    });
                    i.append(l), o.append(a), o.append(i)
                } else this.template(e, t);
                return p.StoreData(t, "data", e), t
            }, s.prototype.bind = function (t, e) {
                var i = this, n = t.id+"-results";
                this.$results.attr("id", n), t.on("results:all", function (e) {
                    i.clear(), i.append(e.data), t.isOpen() && (i.setClasses(), i.highlightFirstItem())
                }), t.on("results:append", function (e) {
                    i.append(e.data), t.isOpen() && i.setClasses()
                }), t.on("query", function (e) {
                    i.hideMessages(), i.showLoading(e)
                }), t.on("select", function () {
                    t.isOpen() && (i.setClasses(), i.options.get("scrollAfterSelect") && i.highlightFirstItem())
                }), t.on("unselect", function () {
                    t.isOpen() && (i.setClasses(), i.options.get("scrollAfterSelect") && i.highlightFirstItem())
                }), t.on("open", function () {
                    i.$results.attr("aria-expanded", "true"), i.$results.attr("aria-hidden", "false"), i.setClasses(), i.ensureHighlightVisible()
                }), t.on("close", function () {
                    i.$results.attr("aria-expanded", "false"), i.$results.attr("aria-hidden", "true"), i.$results.removeAttr("aria-activedescendant")
                }), t.on("results:toggle", function () {
                    var e = i.getHighlightedResults();
                    0 !== e.length && e.trigger("mouseup")
                }), t.on("results:select", function () {
                    var e, t = i.getHighlightedResults();
                    0 !== t.length && (e = p.GetData(t[0], "data"), t.hasClass("select2-results__option--selected") ? i.trigger("close", {}) : i.trigger("select", {data: e}))
                }), t.on("results:previous", function () {
                    var e, t = i.getHighlightedResults(), n = i.$results.find(".select2-results__option--selectable"),
                        s = n.index(t);
                    s <= 0 || (e = s-1, 0 === t.length && (e = 0), (s = n.eq(e)).trigger("mouseenter"), t = i.$results.offset().top, n = s.offset().top, s = i.$results.scrollTop()+(n-t), 0 === e ? i.$results.scrollTop(0) : n-t < 0 && i.$results.scrollTop(s))
                }), t.on("results:next", function () {
                    var e, t = i.getHighlightedResults(), n = i.$results.find(".select2-results__option--selectable"),
                        s = n.index(t)+1;
                    s >= n.length || ((e = n.eq(s)).trigger("mouseenter"), t = i.$results.offset().top+i.$results.outerHeight(!1), n = e.offset().top+e.outerHeight(!1), e = i.$results.scrollTop()+n-t, 0 === s ? i.$results.scrollTop(0) : t < n && i.$results.scrollTop(e))
                }), t.on("results:focus", function (e) {
                    e.element[0].classList.add("select2-results__option--highlighted"), e.element[0].setAttribute("aria-selected", "true")
                }), t.on("results:message", function (e) {
                    i.displayMessage(e)
                }), d.fn.mousewheel && this.$results.on("mousewheel", function (e) {
                    var t = i.$results.scrollTop(), n = i.$results.get(0).scrollHeight-t+e.deltaY,
                        t = 0 < e.deltaY && t-e.deltaY <= 0, n = e.deltaY < 0 && n <= i.$results.height();
                    t ? (i.$results.scrollTop(0), e.preventDefault(), e.stopPropagation()) : n && (i.$results.scrollTop(i.$results.get(0).scrollHeight-i.$results.height()), e.preventDefault(), e.stopPropagation())
                }), this.$results.on("mouseup", ".select2-results__option--selectable", function (e) {
                    var t = d(this), n = p.GetData(this, "data");
                    t.hasClass("select2-results__option--selected") ? i.options.get("multiple") ? i.trigger("unselect", {
                        originalEvent: e,
                        data: n
                    }) : i.trigger("close", {}) : i.trigger("select", {originalEvent: e, data: n})
                }), this.$results.on("mouseenter", ".select2-results__option--selectable", function (e) {
                    var t = p.GetData(this, "data");
                    i.getHighlightedResults().removeClass("select2-results__option--highlighted").attr("aria-selected", "false"), i.trigger("results:focus", {
                        data: t,
                        element: d(this)
                    })
                })
            }, s.prototype.getHighlightedResults = function () {
                return this.$results.find(".select2-results__option--highlighted")
            }, s.prototype.destroy = function () {
                this.$results.remove()
            }, s.prototype.ensureHighlightVisible = function () {
                var e, t, n, s, i = this.getHighlightedResults();
                0 !== i.length && (e = this.$results.find(".select2-results__option--selectable").index(i), s = this.$results.offset().top, t = i.offset().top, n = this.$results.scrollTop()+(t-s), s = t-s, n -= 2 * i.outerHeight(!1), e <= 2 ? this.$results.scrollTop(0) : (s > this.$results.outerHeight() || s < 0) && this.$results.scrollTop(n))
            }, s.prototype.template = function (e, t) {
                var n = this.options.get("templateResult"), s = this.options.get("escapeMarkup"), e = n(e, t);
                null == e ? t.style.display = "none" : "string" == typeof e ? t.innerHTML = s(e) : d(t).append(e)
            }, s
        }), u.define("select2/keys", [], function () {
            return {
                BACKSPACE: 8,
                TAB: 9,
                ENTER: 13,
                SHIFT: 16,
                CTRL: 17,
                ALT: 18,
                ESC: 27,
                SPACE: 32,
                PAGE_UP: 33,
                PAGE_DOWN: 34,
                END: 35,
                HOME: 36,
                LEFT: 37,
                UP: 38,
                RIGHT: 39,
                DOWN: 40,
                DELETE: 46
            }
        }), u.define("select2/selection/base", ["jquery", "../utils", "../keys"], function (n, s, i) {
            function r(e, t) {
                this.$element = e, this.options = t, r.__super__.constructor.call(this)
            }

            return s.Extend(r, s.Observable), r.prototype.render = function () {
                var e = n('<span class="select2-selection" role="combobox"  aria-haspopup="true" aria-expanded="false"></span>');
                return this._tabindex = 0, null != s.GetData(this.$element[0], "old-tabindex") ? this._tabindex = s.GetData(this.$element[0], "old-tabindex") : null != this.$element.attr("tabindex") && (this._tabindex = this.$element.attr("tabindex")), e.attr("title", this.$element.attr("title")), e.attr("tabindex", this._tabindex), e.attr("aria-disabled", "false"), this.$selection = e
            }, r.prototype.bind = function (e, t) {
                var n = this, s = e.id+"-results";
                this.container = e, this.$selection.on("focus", function (e) {
                    n.trigger("focus", e)
                }), this.$selection.on("blur", function (e) {
                    n._handleBlur(e)
                }), this.$selection.on("keydown", function (e) {
                    n.trigger("keypress", e), e.which === i.SPACE && e.preventDefault()
                }), e.on("results:focus", function (e) {
                    n.$selection.attr("aria-activedescendant", e.data._resultId)
                }), e.on("selection:update", function (e) {
                    n.update(e.data)
                }), e.on("open", function () {
                    n.$selection.attr("aria-expanded", "true"), n.$selection.attr("aria-owns", s), n._attachCloseHandler(e)
                }), e.on("close", function () {
                    n.$selection.attr("aria-expanded", "false"), n.$selection.removeAttr("aria-activedescendant"), n.$selection.removeAttr("aria-owns"), n.$selection.trigger("focus"), n._detachCloseHandler(e)
                }), e.on("enable", function () {
                    n.$selection.attr("tabindex", n._tabindex), n.$selection.attr("aria-disabled", "false")
                }), e.on("disable", function () {
                    n.$selection.attr("tabindex", "-1"), n.$selection.attr("aria-disabled", "true")
                })
            }, r.prototype._handleBlur = function (e) {
                var t = this;
                window.setTimeout(function () {
                    document.activeElement == t.$selection[0] || n.contains(t.$selection[0], document.activeElement) || t.trigger("blur", e)
                }, 1)
            }, r.prototype._attachCloseHandler = function (e) {
                n(document.body).on("mousedown.select2."+e.id, function (e) {
                    var t = n(e.target).closest(".select2");
                    n(".select2.select2-container--open").each(function () {
                        this != t[0] && s.GetData(this, "element").select2("close")
                    })
                })
            }, r.prototype._detachCloseHandler = function (e) {
                n(document.body).off("mousedown.select2."+e.id)
            }, r.prototype.position = function (e, t) {
                t.find(".selection").append(e)
            }, r.prototype.destroy = function () {
                this._detachCloseHandler(this.container)
            }, r.prototype.update = function (e) {
                throw new Error("The `update` method must be defined in child classes.")
            }, r.prototype.isEnabled = function () {
                return !this.isDisabled()
            }, r.prototype.isDisabled = function () {
                return this.options.get("disabled")
            }, r
        }), u.define("select2/selection/single", ["jquery", "./base", "../utils", "../keys"], function (e, t, n, s) {
            function i() {
                i.__super__.constructor.apply(this, arguments)
            }

            return n.Extend(i, t), i.prototype.render = function () {
                var e = i.__super__.render.call(this);
                return e[0].classList.add("select2-selection--single"), e.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'), e
            }, i.prototype.bind = function (t, e) {
                var n = this;
                i.__super__.bind.apply(this, arguments);
                var s = t.id+"-container";
                this.$selection.find(".select2-selection__rendered").attr("id", s).attr("role", "textbox").attr("aria-readonly", "true"), this.$selection.attr("aria-labelledby", s), this.$selection.attr("aria-controls", s), this.$selection.on("mousedown", function (e) {
                    1 === e.which && n.trigger("toggle", {originalEvent: e})
                }), this.$selection.on("focus", function (e) {
                }), this.$selection.on("blur", function (e) {
                }), t.on("focus", function (e) {
                    t.isOpen() || n.$selection.trigger("focus")
                })
            }, i.prototype.clear = function () {
                var e = this.$selection.find(".select2-selection__rendered");
                e.empty(), e.removeAttr("title")
            }, i.prototype.display = function (e, t) {
                var n = this.options.get("templateSelection");
                return this.options.get("escapeMarkup")(n(e, t))
            }, i.prototype.selectionContainer = function () {
                return e("<span></span>")
            }, i.prototype.update = function (e) {
                var t, n;
                0 !== e.length ? (n = e[0], t = this.$selection.find(".select2-selection__rendered"), e = this.display(n, t), t.empty().append(e), (n = n.title || n.text) ? t.attr("title", n) : t.removeAttr("title")) : this.clear()
            }, i
        }), u.define("select2/selection/multiple", ["jquery", "./base", "../utils"], function (i, e, c) {
            function r(e, t) {
                r.__super__.constructor.apply(this, arguments)
            }

            return c.Extend(r, e), r.prototype.render = function () {
                var e = r.__super__.render.call(this);
                return e[0].classList.add("select2-selection--multiple"), e.html('<ul class="select2-selection__rendered"></ul>'), e
            }, r.prototype.bind = function (e, t) {
                var n = this;
                r.__super__.bind.apply(this, arguments);
                var s = e.id+"-container";
                this.$selection.find(".select2-selection__rendered").attr("id", s), this.$selection.on("click", function (e) {
                    n.trigger("toggle", {originalEvent: e})
                }), this.$selection.on("click", ".select2-selection__choice__remove", function (e) {
                    var t;
                    n.isDisabled() || (t = i(this).parent(), t = c.GetData(t[0], "data"), n.trigger("unselect", {
                        originalEvent: e,
                        data: t
                    }))
                }), this.$selection.on("keydown", ".select2-selection__choice__remove", function (e) {
                    n.isDisabled() || e.stopPropagation()
                })
            }, r.prototype.clear = function () {
                var e = this.$selection.find(".select2-selection__rendered");
                e.empty(), e.removeAttr("title")
            }, r.prototype.display = function (e, t) {
                var n = this.options.get("templateSelection");
                return this.options.get("escapeMarkup")(n(e, t))
            }, r.prototype.selectionContainer = function () {
                return i('<li class="select2-selection__choice"><button type="button" class="select2-selection__choice__remove" tabindex="-1"><span aria-hidden="true">&times;</span></button><span class="select2-selection__choice__display"></span></li>')
            }, r.prototype.update = function (e) {
                if (this.clear(), 0 !== e.length) {
                    for (var t = [], n = this.$selection.find(".select2-selection__rendered").attr("id")+"-choice-", s = 0; s < e.length; s++) {
                        var i = e[s], r = this.selectionContainer(), o = this.display(i, r),
                            a = n+c.generateChars(4)+"-";
                        i.id ? a += i.id : a += c.generateChars(4), r.find(".select2-selection__choice__display").append(o).attr("id", a);
                        var l = i.title || i.text;
                        l && r.attr("title", l);
                        o = this.options.get("translations").get("removeItem"), l = r.find(".select2-selection__choice__remove");
                        l.attr("title", o()), l.attr("aria-label", o()), l.attr("aria-describedby", a), c.StoreData(r[0], "data", i), t.push(r)
                    }
                    this.$selection.find(".select2-selection__rendered").append(t)
                }
            }, r
        }), u.define("select2/selection/placeholder", [], function () {
            function e(e, t, n) {
                this.placeholder = this.normalizePlaceholder(n.get("placeholder")), e.call(this, t, n)
            }

            return e.prototype.normalizePlaceholder = function (e, t) {
                return t = "string" == typeof t ? {id: "", text: t} : t
            }, e.prototype.createPlaceholder = function (e, t) {
                var n = this.selectionContainer();
                n.html(this.display(t)), n[0].classList.add("select2-selection__placeholder"), n[0].classList.remove("select2-selection__choice");
                t = t.title || t.text || n.text();
                return this.$selection.find(".select2-selection__rendered").attr("title", t), n
            }, e.prototype.update = function (e, t) {
                var n = 1 == t.length && t[0].id != this.placeholder.id;
                if (1 < t.length || n) return e.call(this, t);
                this.clear();
                t = this.createPlaceholder(this.placeholder);
                this.$selection.find(".select2-selection__rendered").append(t)
            }, e
        }), u.define("select2/selection/allowClear", ["jquery", "../keys", "../utils"], function (i, s, a) {
            function e() {
            }

            return e.prototype.bind = function (e, t, n) {
                var s = this;
                e.call(this, t, n), null == this.placeholder && this.options.get("debug") && window.console && console.error && console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."), this.$selection.on("mousedown", ".select2-selection__clear", function (e) {
                    s._handleClear(e)
                }), t.on("keypress", function (e) {
                    s._handleKeyboardClear(e, t)
                })
            }, e.prototype._handleClear = function (e, t) {
                if (!this.isDisabled()) {
                    var n = this.$selection.find(".select2-selection__clear");
                    if (0 !== n.length) {
                        t.stopPropagation();
                        var s = a.GetData(n[0], "data"), i = this.$element.val();
                        this.$element.val(this.placeholder.id);
                        var r = {data: s};
                        if (this.trigger("clear", r), r.prevented) this.$element.val(i); else {
                            for (var o = 0; o < s.length; o++) if (r = {data: s[o]}, this.trigger("unselect", r), r.prevented) return void this.$element.val(i);
                            this.$element.trigger("input").trigger("change"), this.trigger("toggle", {})
                        }
                    }
                }
            }, e.prototype._handleKeyboardClear = function (e, t, n) {
                n.isOpen() || t.which != s.DELETE && t.which != s.BACKSPACE || this._handleClear(t)
            }, e.prototype.update = function (e, t) {
                var n, s;
                e.call(this, t), this.$selection.find(".select2-selection__clear").remove(), this.$selection[0].classList.remove("select2-selection--clearable"), 0 < this.$selection.find(".select2-selection__placeholder").length || 0 === t.length || (n = this.$selection.find(".select2-selection__rendered").attr("id"), s = this.options.get("translations").get("removeAllItems"), (e = i('<button type="button" class="select2-selection__clear" tabindex="-1"><span aria-hidden="true">&times;</span></button>')).attr("title", s()), e.attr("aria-label", s()), e.attr("aria-describedby", n), a.StoreData(e[0], "data", t), this.$selection.prepend(e), this.$selection[0].classList.add("select2-selection--clearable"))
            }, e
        }), u.define("select2/selection/search", ["jquery", "../utils", "../keys"], function (s, a, l) {
            function e(e, t, n) {
                e.call(this, t, n)
            }

            return e.prototype.render = function (e) {
                var t = this.options.get("translations").get("search"),
                    n = s('<span class="select2-search select2-search--inline"><textarea class="select2-search__field" type="search" tabindex="-1" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" ></textarea></span>');
                this.$searchContainer = n, this.$search = n.find("textarea"), this.$search.prop("autocomplete", this.options.get("autocomplete")), this.$search.attr("aria-label", t());
                e = e.call(this);
                return this._transferTabIndex(), e.append(this.$searchContainer), e
            }, e.prototype.bind = function (e, t, n) {
                var s = this, i = t.id+"-results", r = t.id+"-container";
                e.call(this, t, n), s.$search.attr("aria-describedby", r), t.on("open", function () {
                    s.$search.attr("aria-controls", i), s.$search.trigger("focus")
                }), t.on("close", function () {
                    s.$search.val(""), s.resizeSearch(), s.$search.removeAttr("aria-controls"), s.$search.removeAttr("aria-activedescendant"), s.$search.trigger("focus")
                }), t.on("enable", function () {
                    s.$search.prop("disabled", !1), s._transferTabIndex()
                }), t.on("disable", function () {
                    s.$search.prop("disabled", !0)
                }), t.on("focus", function (e) {
                    s.$search.trigger("focus")
                }), t.on("results:focus", function (e) {
                    e.data._resultId ? s.$search.attr("aria-activedescendant", e.data._resultId) : s.$search.removeAttr("aria-activedescendant")
                }), this.$selection.on("focusin", ".select2-search--inline", function (e) {
                    s.trigger("focus", e)
                }), this.$selection.on("focusout", ".select2-search--inline", function (e) {
                    s._handleBlur(e)
                }), this.$selection.on("keydown", ".select2-search--inline", function (e) {
                    var t;
                    e.stopPropagation(), s.trigger("keypress", e), s._keyUpPrevented = e.isDefaultPrevented(), e.which !== l.BACKSPACE || "" !== s.$search.val() || 0 < (t = s.$selection.find(".select2-selection__choice").last()).length && (t = a.GetData(t[0], "data"), s.searchRemoveChoice(t), e.preventDefault())
                }), this.$selection.on("click", ".select2-search--inline", function (e) {
                    s.$search.val() && e.stopPropagation()
                });
                var t = document.documentMode, o = t && t <= 11;
                this.$selection.on("input.searchcheck", ".select2-search--inline", function (e) {
                    o ? s.$selection.off("input.search input.searchcheck") : s.$selection.off("keyup.search")
                }), this.$selection.on("keyup.search input.search", ".select2-search--inline", function (e) {
                    var t;
                    o && "input" === e.type ? s.$selection.off("input.search input.searchcheck") : (t = e.which) != l.SHIFT && t != l.CTRL && t != l.ALT && t != l.TAB && s.handleSearch(e)
                })
            }, e.prototype._transferTabIndex = function (e) {
                this.$search.attr("tabindex", this.$selection.attr("tabindex")), this.$selection.attr("tabindex", "-1")
            }, e.prototype.createPlaceholder = function (e, t) {
                this.$search.attr("placeholder", t.text)
            }, e.prototype.update = function (e, t) {
                var n = this.$search[0] == document.activeElement;
                this.$search.attr("placeholder", ""), e.call(this, t), this.resizeSearch(), n && this.$search.trigger("focus")
            }, e.prototype.handleSearch = function () {
                var e;
                this.resizeSearch(), this._keyUpPrevented || (e = this.$search.val(), this.trigger("query", {term: e})), this._keyUpPrevented = !1
            }, e.prototype.searchRemoveChoice = function (e, t) {
                this.trigger("unselect", {data: t}), this.$search.val(t.text), this.handleSearch()
            }, e.prototype.resizeSearch = function () {
                this.$search.css("width", "25px");
                var e = "100%";
                "" === this.$search.attr("placeholder") && (e = .75 * (this.$search.val().length+1)+"em"), this.$search.css("width", e)
            }, e
        }), u.define("select2/selection/selectionCss", ["../utils"], function (n) {
            function e() {
            }

            return e.prototype.render = function (e) {
                var t = e.call(this), e = this.options.get("selectionCssClass") || "";
                return -1 !== e.indexOf(":all:") && (e = e.replace(":all:", ""), n.copyNonInternalCssClasses(t[0], this.$element[0])), t.addClass(e), t
            }, e
        }), u.define("select2/selection/eventRelay", ["jquery"], function (o) {
            function e() {
            }

            return e.prototype.bind = function (e, t, n) {
                var s = this,
                    i = ["open", "opening", "close", "closing", "select", "selecting", "unselect", "unselecting", "clear", "clearing"],
                    r = ["opening", "closing", "selecting", "unselecting", "clearing"];
                e.call(this, t, n), t.on("*", function (e, t) {
                    var n;
                    -1 !== i.indexOf(e) && (t = t || {}, n = o.Event("select2:"+e, {params: t}), s.$element.trigger(n), -1 !== r.indexOf(e) && (t.prevented = n.isDefaultPrevented()))
                })
            }, e
        }), u.define("select2/translation", ["jquery", "require"], function (t, n) {
            function s(e) {
                this.dict = e || {}
            }

            return s.prototype.all = function () {
                return this.dict
            }, s.prototype.get = function (e) {
                return this.dict[e]
            }, s.prototype.extend = function (e) {
                this.dict = t.extend({}, e.all(), this.dict)
            }, s._cache = {}, s.loadPath = function (e) {
                var t;
                return e in s._cache || (t = n(e), s._cache[e] = t), new s(s._cache[e])
            }, s
        }), u.define("select2/diacritics", [], function () {
            return {
                "Ⓐ": "A",
                "Ａ": "A",
                "À": "A",
                "Á": "A",
                "Â": "A",
                "Ầ": "A",
                "Ấ": "A",
                "Ẫ": "A",
                "Ẩ": "A",
                "Ã": "A",
                "Ā": "A",
                "Ă": "A",
                "Ằ": "A",
                "Ắ": "A",
                "Ẵ": "A",
                "Ẳ": "A",
                "Ȧ": "A",
                "Ǡ": "A",
                "Ä": "A",
                "Ǟ": "A",
                "Ả": "A",
                "Å": "A",
                "Ǻ": "A",
                "Ǎ": "A",
                "Ȁ": "A",
                "Ȃ": "A",
                "Ạ": "A",
                "Ậ": "A",
                "Ặ": "A",
                "Ḁ": "A",
                "Ą": "A",
                "Ⱥ": "A",
                "Ɐ": "A",
                "Ꜳ": "AA",
                "Æ": "AE",
                "Ǽ": "AE",
                "Ǣ": "AE",
                "Ꜵ": "AO",
                "Ꜷ": "AU",
                "Ꜹ": "AV",
                "Ꜻ": "AV",
                "Ꜽ": "AY",
                "Ⓑ": "B",
                "Ｂ": "B",
                "Ḃ": "B",
                "Ḅ": "B",
                "Ḇ": "B",
                "Ƀ": "B",
                "Ƃ": "B",
                "Ɓ": "B",
                "Ⓒ": "C",
                "Ｃ": "C",
                "Ć": "C",
                "Ĉ": "C",
                "Ċ": "C",
                "Č": "C",
                "Ç": "C",
                "Ḉ": "C",
                "Ƈ": "C",
                "Ȼ": "C",
                "Ꜿ": "C",
                "Ⓓ": "D",
                "Ｄ": "D",
                "Ḋ": "D",
                "Ď": "D",
                "Ḍ": "D",
                "Ḑ": "D",
                "Ḓ": "D",
                "Ḏ": "D",
                "Đ": "D",
                "Ƌ": "D",
                "Ɗ": "D",
                "Ɖ": "D",
                "Ꝺ": "D",
                "Ǳ": "DZ",
                "Ǆ": "DZ",
                "ǲ": "Dz",
                "ǅ": "Dz",
                "Ⓔ": "E",
                "Ｅ": "E",
                "È": "E",
                "É": "E",
                "Ê": "E",
                "Ề": "E",
                "Ế": "E",
                "Ễ": "E",
                "Ể": "E",
                "Ẽ": "E",
                "Ē": "E",
                "Ḕ": "E",
                "Ḗ": "E",
                "Ĕ": "E",
                "Ė": "E",
                "Ë": "E",
                "Ẻ": "E",
                "Ě": "E",
                "Ȅ": "E",
                "Ȇ": "E",
                "Ẹ": "E",
                "Ệ": "E",
                "Ȩ": "E",
                "Ḝ": "E",
                "Ę": "E",
                "Ḙ": "E",
                "Ḛ": "E",
                "Ɛ": "E",
                "Ǝ": "E",
                "Ⓕ": "F",
                "Ｆ": "F",
                "Ḟ": "F",
                "Ƒ": "F",
                "Ꝼ": "F",
                "Ⓖ": "G",
                "Ｇ": "G",
                "Ǵ": "G",
                "Ĝ": "G",
                "Ḡ": "G",
                "Ğ": "G",
                "Ġ": "G",
                "Ǧ": "G",
                "Ģ": "G",
                "Ǥ": "G",
                "Ɠ": "G",
                "Ꞡ": "G",
                "Ᵹ": "G",
                "Ꝿ": "G",
                "Ⓗ": "H",
                "Ｈ": "H",
                "Ĥ": "H",
                "Ḣ": "H",
                "Ḧ": "H",
                "Ȟ": "H",
                "Ḥ": "H",
                "Ḩ": "H",
                "Ḫ": "H",
                "Ħ": "H",
                "Ⱨ": "H",
                "Ⱶ": "H",
                "Ɥ": "H",
                "Ⓘ": "I",
                "Ｉ": "I",
                "Ì": "I",
                "Í": "I",
                "Î": "I",
                "Ĩ": "I",
                "Ī": "I",
                "Ĭ": "I",
                "İ": "I",
                "Ï": "I",
                "Ḯ": "I",
                "Ỉ": "I",
                "Ǐ": "I",
                "Ȉ": "I",
                "Ȋ": "I",
                "Ị": "I",
                "Į": "I",
                "Ḭ": "I",
                "Ɨ": "I",
                "Ⓙ": "J",
                "Ｊ": "J",
                "Ĵ": "J",
                "Ɉ": "J",
                "Ⓚ": "K",
                "Ｋ": "K",
                "Ḱ": "K",
                "Ǩ": "K",
                "Ḳ": "K",
                "Ķ": "K",
                "Ḵ": "K",
                "Ƙ": "K",
                "Ⱪ": "K",
                "Ꝁ": "K",
                "Ꝃ": "K",
                "Ꝅ": "K",
                "Ꞣ": "K",
                "Ⓛ": "L",
                "Ｌ": "L",
                "Ŀ": "L",
                "Ĺ": "L",
                "Ľ": "L",
                "Ḷ": "L",
                "Ḹ": "L",
                "Ļ": "L",
                "Ḽ": "L",
                "Ḻ": "L",
                "Ł": "L",
                "Ƚ": "L",
                "Ɫ": "L",
                "Ⱡ": "L",
                "Ꝉ": "L",
                "Ꝇ": "L",
                "Ꞁ": "L",
                "Ǉ": "LJ",
                "ǈ": "Lj",
                "Ⓜ": "M",
                "Ｍ": "M",
                "Ḿ": "M",
                "Ṁ": "M",
                "Ṃ": "M",
                "Ɱ": "M",
                "Ɯ": "M",
                "Ⓝ": "N",
                "Ｎ": "N",
                "Ǹ": "N",
                "Ń": "N",
                "Ñ": "N",
                "Ṅ": "N",
                "Ň": "N",
                "Ṇ": "N",
                "Ņ": "N",
                "Ṋ": "N",
                "Ṉ": "N",
                "Ƞ": "N",
                "Ɲ": "N",
                "Ꞑ": "N",
                "Ꞥ": "N",
                "Ǌ": "NJ",
                "ǋ": "Nj",
                "Ⓞ": "O",
                "Ｏ": "O",
                "Ò": "O",
                "Ó": "O",
                "Ô": "O",
                "Ồ": "O",
                "Ố": "O",
                "Ỗ": "O",
                "Ổ": "O",
                "Õ": "O",
                "Ṍ": "O",
                "Ȭ": "O",
                "Ṏ": "O",
                "Ō": "O",
                "Ṑ": "O",
                "Ṓ": "O",
                "Ŏ": "O",
                "Ȯ": "O",
                "Ȱ": "O",
                "Ö": "O",
                "Ȫ": "O",
                "Ỏ": "O",
                "Ő": "O",
                "Ǒ": "O",
                "Ȍ": "O",
                "Ȏ": "O",
                "Ơ": "O",
                "Ờ": "O",
                "Ớ": "O",
                "Ỡ": "O",
                "Ở": "O",
                "Ợ": "O",
                "Ọ": "O",
                "Ộ": "O",
                "Ǫ": "O",
                "Ǭ": "O",
                "Ø": "O",
                "Ǿ": "O",
                "Ɔ": "O",
                "Ɵ": "O",
                "Ꝋ": "O",
                "Ꝍ": "O",
                "Œ": "OE",
                "Ƣ": "OI",
                "Ꝏ": "OO",
                "Ȣ": "OU",
                "Ⓟ": "P",
                "Ｐ": "P",
                "Ṕ": "P",
                "Ṗ": "P",
                "Ƥ": "P",
                "Ᵽ": "P",
                "Ꝑ": "P",
                "Ꝓ": "P",
                "Ꝕ": "P",
                "Ⓠ": "Q",
                "Ｑ": "Q",
                "Ꝗ": "Q",
                "Ꝙ": "Q",
                "Ɋ": "Q",
                "Ⓡ": "R",
                "Ｒ": "R",
                "Ŕ": "R",
                "Ṙ": "R",
                "Ř": "R",
                "Ȑ": "R",
                "Ȓ": "R",
                "Ṛ": "R",
                "Ṝ": "R",
                "Ŗ": "R",
                "Ṟ": "R",
                "Ɍ": "R",
                "Ɽ": "R",
                "Ꝛ": "R",
                "Ꞧ": "R",
                "Ꞃ": "R",
                "Ⓢ": "S",
                "Ｓ": "S",
                "ẞ": "S",
                "Ś": "S",
                "Ṥ": "S",
                "Ŝ": "S",
                "Ṡ": "S",
                "Š": "S",
                "Ṧ": "S",
                "Ṣ": "S",
                "Ṩ": "S",
                "Ș": "S",
                "Ş": "S",
                "Ȿ": "S",
                "Ꞩ": "S",
                "Ꞅ": "S",
                "Ⓣ": "T",
                "Ｔ": "T",
                "Ṫ": "T",
                "Ť": "T",
                "Ṭ": "T",
                "Ț": "T",
                "Ţ": "T",
                "Ṱ": "T",
                "Ṯ": "T",
                "Ŧ": "T",
                "Ƭ": "T",
                "Ʈ": "T",
                "Ⱦ": "T",
                "Ꞇ": "T",
                "Ꜩ": "TZ",
                "Ⓤ": "U",
                "Ｕ": "U",
                "Ù": "U",
                "Ú": "U",
                "Û": "U",
                "Ũ": "U",
                "Ṹ": "U",
                "Ū": "U",
                "Ṻ": "U",
                "Ŭ": "U",
                "Ü": "U",
                "Ǜ": "U",
                "Ǘ": "U",
                "Ǖ": "U",
                "Ǚ": "U",
                "Ủ": "U",
                "Ů": "U",
                "Ű": "U",
                "Ǔ": "U",
                "Ȕ": "U",
                "Ȗ": "U",
                "Ư": "U",
                "Ừ": "U",
                "Ứ": "U",
                "Ữ": "U",
                "Ử": "U",
                "Ự": "U",
                "Ụ": "U",
                "Ṳ": "U",
                "Ų": "U",
                "Ṷ": "U",
                "Ṵ": "U",
                "Ʉ": "U",
                "Ⓥ": "V",
                "Ｖ": "V",
                "Ṽ": "V",
                "Ṿ": "V",
                "Ʋ": "V",
                "Ꝟ": "V",
                "Ʌ": "V",
                "Ꝡ": "VY",
                "Ⓦ": "W",
                "Ｗ": "W",
                "Ẁ": "W",
                "Ẃ": "W",
                "Ŵ": "W",
                "Ẇ": "W",
                "Ẅ": "W",
                "Ẉ": "W",
                "Ⱳ": "W",
                "Ⓧ": "X",
                "Ｘ": "X",
                "Ẋ": "X",
                "Ẍ": "X",
                "Ⓨ": "Y",
                "Ｙ": "Y",
                "Ỳ": "Y",
                "Ý": "Y",
                "Ŷ": "Y",
                "Ỹ": "Y",
                "Ȳ": "Y",
                "Ẏ": "Y",
                "Ÿ": "Y",
                "Ỷ": "Y",
                "Ỵ": "Y",
                "Ƴ": "Y",
                "Ɏ": "Y",
                "Ỿ": "Y",
                "Ⓩ": "Z",
                "Ｚ": "Z",
                "Ź": "Z",
                "Ẑ": "Z",
                "Ż": "Z",
                "Ž": "Z",
                "Ẓ": "Z",
                "Ẕ": "Z",
                "Ƶ": "Z",
                "Ȥ": "Z",
                "Ɀ": "Z",
                "Ⱬ": "Z",
                "Ꝣ": "Z",
                "ⓐ": "a",
                "ａ": "a",
                "ẚ": "a",
                "à": "a",
                "á": "a",
                "â": "a",
                "ầ": "a",
                "ấ": "a",
                "ẫ": "a",
                "ẩ": "a",
                "ã": "a",
                "ā": "a",
                "ă": "a",
                "ằ": "a",
                "ắ": "a",
                "ẵ": "a",
                "ẳ": "a",
                "ȧ": "a",
                "ǡ": "a",
                "ä": "a",
                "ǟ": "a",
                "ả": "a",
                "å": "a",
                "ǻ": "a",
                "ǎ": "a",
                "ȁ": "a",
                "ȃ": "a",
                "ạ": "a",
                "ậ": "a",
                "ặ": "a",
                "ḁ": "a",
                "ą": "a",
                "ⱥ": "a",
                "ɐ": "a",
                "ꜳ": "aa",
                "æ": "ae",
                "ǽ": "ae",
                "ǣ": "ae",
                "ꜵ": "ao",
                "ꜷ": "au",
                "ꜹ": "av",
                "ꜻ": "av",
                "ꜽ": "ay",
                "ⓑ": "b",
                "ｂ": "b",
                "ḃ": "b",
                "ḅ": "b",
                "ḇ": "b",
                "ƀ": "b",
                "ƃ": "b",
                "ɓ": "b",
                "ⓒ": "c",
                "ｃ": "c",
                "ć": "c",
                "ĉ": "c",
                "ċ": "c",
                "č": "c",
                "ç": "c",
                "ḉ": "c",
                "ƈ": "c",
                "ȼ": "c",
                "ꜿ": "c",
                "ↄ": "c",
                "ⓓ": "d",
                "ｄ": "d",
                "ḋ": "d",
                "ď": "d",
                "ḍ": "d",
                "ḑ": "d",
                "ḓ": "d",
                "ḏ": "d",
                "đ": "d",
                "ƌ": "d",
                "ɖ": "d",
                "ɗ": "d",
                "ꝺ": "d",
                "ǳ": "dz",
                "ǆ": "dz",
                "ⓔ": "e",
                "ｅ": "e",
                "è": "e",
                "é": "e",
                "ê": "e",
                "ề": "e",
                "ế": "e",
                "ễ": "e",
                "ể": "e",
                "ẽ": "e",
                "ē": "e",
                "ḕ": "e",
                "ḗ": "e",
                "ĕ": "e",
                "ė": "e",
                "ë": "e",
                "ẻ": "e",
                "ě": "e",
                "ȅ": "e",
                "ȇ": "e",
                "ẹ": "e",
                "ệ": "e",
                "ȩ": "e",
                "ḝ": "e",
                "ę": "e",
                "ḙ": "e",
                "ḛ": "e",
                "ɇ": "e",
                "ɛ": "e",
                "ǝ": "e",
                "ⓕ": "f",
                "ｆ": "f",
                "ḟ": "f",
                "ƒ": "f",
                "ꝼ": "f",
                "ⓖ": "g",
                "ｇ": "g",
                "ǵ": "g",
                "ĝ": "g",
                "ḡ": "g",
                "ğ": "g",
                "ġ": "g",
                "ǧ": "g",
                "ģ": "g",
                "ǥ": "g",
                "ɠ": "g",
                "ꞡ": "g",
                "ᵹ": "g",
                "ꝿ": "g",
                "ⓗ": "h",
                "ｈ": "h",
                "ĥ": "h",
                "ḣ": "h",
                "ḧ": "h",
                "ȟ": "h",
                "ḥ": "h",
                "ḩ": "h",
                "ḫ": "h",
                "ẖ": "h",
                "ħ": "h",
                "ⱨ": "h",
                "ⱶ": "h",
                "ɥ": "h",
                "ƕ": "hv",
                "ⓘ": "i",
                "ｉ": "i",
                "ì": "i",
                "í": "i",
                "î": "i",
                "ĩ": "i",
                "ī": "i",
                "ĭ": "i",
                "ï": "i",
                "ḯ": "i",
                "ỉ": "i",
                "ǐ": "i",
                "ȉ": "i",
                "ȋ": "i",
                "ị": "i",
                "į": "i",
                "ḭ": "i",
                "ɨ": "i",
                "ı": "i",
                "ⓙ": "j",
                "ｊ": "j",
                "ĵ": "j",
                "ǰ": "j",
                "ɉ": "j",
                "ⓚ": "k",
                "ｋ": "k",
                "ḱ": "k",
                "ǩ": "k",
                "ḳ": "k",
                "ķ": "k",
                "ḵ": "k",
                "ƙ": "k",
                "ⱪ": "k",
                "ꝁ": "k",
                "ꝃ": "k",
                "ꝅ": "k",
                "ꞣ": "k",
                "ⓛ": "l",
                "ｌ": "l",
                "ŀ": "l",
                "ĺ": "l",
                "ľ": "l",
                "ḷ": "l",
                "ḹ": "l",
                "ļ": "l",
                "ḽ": "l",
                "ḻ": "l",
                "ſ": "l",
                "ł": "l",
                "ƚ": "l",
                "ɫ": "l",
                "ⱡ": "l",
                "ꝉ": "l",
                "ꞁ": "l",
                "ꝇ": "l",
                "ǉ": "lj",
                "ⓜ": "m",
                "ｍ": "m",
                "ḿ": "m",
                "ṁ": "m",
                "ṃ": "m",
                "ɱ": "m",
                "ɯ": "m",
                "ⓝ": "n",
                "ｎ": "n",
                "ǹ": "n",
                "ń": "n",
                "ñ": "n",
                "ṅ": "n",
                "ň": "n",
                "ṇ": "n",
                "ņ": "n",
                "ṋ": "n",
                "ṉ": "n",
                "ƞ": "n",
                "ɲ": "n",
                "ŉ": "n",
                "ꞑ": "n",
                "ꞥ": "n",
                "ǌ": "nj",
                "ⓞ": "o",
                "ｏ": "o",
                "ò": "o",
                "ó": "o",
                "ô": "o",
                "ồ": "o",
                "ố": "o",
                "ỗ": "o",
                "ổ": "o",
                "õ": "o",
                "ṍ": "o",
                "ȭ": "o",
                "ṏ": "o",
                "ō": "o",
                "ṑ": "o",
                "ṓ": "o",
                "ŏ": "o",
                "ȯ": "o",
                "ȱ": "o",
                "ö": "o",
                "ȫ": "o",
                "ỏ": "o",
                "ő": "o",
                "ǒ": "o",
                "ȍ": "o",
                "ȏ": "o",
                "ơ": "o",
                "ờ": "o",
                "ớ": "o",
                "ỡ": "o",
                "ở": "o",
                "ợ": "o",
                "ọ": "o",
                "ộ": "o",
                "ǫ": "o",
                "ǭ": "o",
                "ø": "o",
                "ǿ": "o",
                "ɔ": "o",
                "ꝋ": "o",
                "ꝍ": "o",
                "ɵ": "o",
                "œ": "oe",
                "ƣ": "oi",
                "ȣ": "ou",
                "ꝏ": "oo",
                "ⓟ": "p",
                "ｐ": "p",
                "ṕ": "p",
                "ṗ": "p",
                "ƥ": "p",
                "ᵽ": "p",
                "ꝑ": "p",
                "ꝓ": "p",
                "ꝕ": "p",
                "ⓠ": "q",
                "ｑ": "q",
                "ɋ": "q",
                "ꝗ": "q",
                "ꝙ": "q",
                "ⓡ": "r",
                "ｒ": "r",
                "ŕ": "r",
                "ṙ": "r",
                "ř": "r",
                "ȑ": "r",
                "ȓ": "r",
                "ṛ": "r",
                "ṝ": "r",
                "ŗ": "r",
                "ṟ": "r",
                "ɍ": "r",
                "ɽ": "r",
                "ꝛ": "r",
                "ꞧ": "r",
                "ꞃ": "r",
                "ⓢ": "s",
                "ｓ": "s",
                "ß": "s",
                "ś": "s",
                "ṥ": "s",
                "ŝ": "s",
                "ṡ": "s",
                "š": "s",
                "ṧ": "s",
                "ṣ": "s",
                "ṩ": "s",
                "ș": "s",
                "ş": "s",
                "ȿ": "s",
                "ꞩ": "s",
                "ꞅ": "s",
                "ẛ": "s",
                "ⓣ": "t",
                "ｔ": "t",
                "ṫ": "t",
                "ẗ": "t",
                "ť": "t",
                "ṭ": "t",
                "ț": "t",
                "ţ": "t",
                "ṱ": "t",
                "ṯ": "t",
                "ŧ": "t",
                "ƭ": "t",
                "ʈ": "t",
                "ⱦ": "t",
                "ꞇ": "t",
                "ꜩ": "tz",
                "ⓤ": "u",
                "ｕ": "u",
                "ù": "u",
                "ú": "u",
                "û": "u",
                "ũ": "u",
                "ṹ": "u",
                "ū": "u",
                "ṻ": "u",
                "ŭ": "u",
                "ü": "u",
                "ǜ": "u",
                "ǘ": "u",
                "ǖ": "u",
                "ǚ": "u",
                "ủ": "u",
                "ů": "u",
                "ű": "u",
                "ǔ": "u",
                "ȕ": "u",
                "ȗ": "u",
                "ư": "u",
                "ừ": "u",
                "ứ": "u",
                "ữ": "u",
                "ử": "u",
                "ự": "u",
                "ụ": "u",
                "ṳ": "u",
                "ų": "u",
                "ṷ": "u",
                "ṵ": "u",
                "ʉ": "u",
                "ⓥ": "v",
                "ｖ": "v",
                "ṽ": "v",
                "ṿ": "v",
                "ʋ": "v",
                "ꝟ": "v",
                "ʌ": "v",
                "ꝡ": "vy",
                "ⓦ": "w",
                "ｗ": "w",
                "ẁ": "w",
                "ẃ": "w",
                "ŵ": "w",
                "ẇ": "w",
                "ẅ": "w",
                "ẘ": "w",
                "ẉ": "w",
                "ⱳ": "w",
                "ⓧ": "x",
                "ｘ": "x",
                "ẋ": "x",
                "ẍ": "x",
                "ⓨ": "y",
                "ｙ": "y",
                "ỳ": "y",
                "ý": "y",
                "ŷ": "y",
                "ỹ": "y",
                "ȳ": "y",
                "ẏ": "y",
                "ÿ": "y",
                "ỷ": "y",
                "ẙ": "y",
                "ỵ": "y",
                "ƴ": "y",
                "ɏ": "y",
                "ỿ": "y",
                "ⓩ": "z",
                "ｚ": "z",
                "ź": "z",
                "ẑ": "z",
                "ż": "z",
                "ž": "z",
                "ẓ": "z",
                "ẕ": "z",
                "ƶ": "z",
                "ȥ": "z",
                "ɀ": "z",
                "ⱬ": "z",
                "ꝣ": "z",
                "Ά": "Α",
                "Έ": "Ε",
                "Ή": "Η",
                "Ί": "Ι",
                "Ϊ": "Ι",
                "Ό": "Ο",
                "Ύ": "Υ",
                "Ϋ": "Υ",
                "Ώ": "Ω",
                "ά": "α",
                "έ": "ε",
                "ή": "η",
                "ί": "ι",
                "ϊ": "ι",
                "ΐ": "ι",
                "ό": "ο",
                "ύ": "υ",
                "ϋ": "υ",
                "ΰ": "υ",
                "ώ": "ω",
                "ς": "σ",
                "’": "'"
            }
        }), u.define("select2/data/base", ["../utils"], function (n) {
            function s(e, t) {
                s.__super__.constructor.call(this)
            }

            return n.Extend(s, n.Observable), s.prototype.current = function (e) {
                throw new Error("The `current` method must be defined in child classes.")
            }, s.prototype.query = function (e, t) {
                throw new Error("The `query` method must be defined in child classes.")
            }, s.prototype.bind = function (e, t) {
            }, s.prototype.destroy = function () {
            }, s.prototype.generateResultId = function (e, t) {
                e = e.id+"-result-";
                return e += n.generateChars(4), null != t.id ? e += "-"+t.id.toString() : e += "-"+n.generateChars(4), e
            }, s
        }), u.define("select2/data/select", ["./base", "../utils", "jquery"], function (e, a, l) {
            function n(e, t) {
                this.$element = e, this.options = t, n.__super__.constructor.call(this)
            }

            return a.Extend(n, e), n.prototype.current = function (e) {
                var t = this;
                e(Array.prototype.map.call(this.$element[0].querySelectorAll(":checked"), function (e) {
                    return t.item(l(e))
                }))
            }, n.prototype.select = function (i) {
                var e, r = this;
                if (i.selected = !0, null != i.element && "option" === i.element.tagName.toLowerCase()) return i.element.selected = !0, void this.$element.trigger("input").trigger("change");
                this.$element.prop("multiple") ? this.current(function (e) {
                    var t = [];
                    (i = [i]).push.apply(i, e);
                    for (var n = 0; n < i.length; n++) {
                        var s = i[n].id;
                        -1 === t.indexOf(s) && t.push(s)
                    }
                    r.$element.val(t), r.$element.trigger("input").trigger("change")
                }) : (e = i.id, this.$element.val(e), this.$element.trigger("input").trigger("change"))
            }, n.prototype.unselect = function (i) {
                var r = this;
                if (this.$element.prop("multiple")) {
                    if (i.selected = !1, null != i.element && "option" === i.element.tagName.toLowerCase()) return i.element.selected = !1, void this.$element.trigger("input").trigger("change");
                    this.current(function (e) {
                        for (var t = [], n = 0; n < e.length; n++) {
                            var s = e[n].id;
                            s !== i.id && -1 === t.indexOf(s) && t.push(s)
                        }
                        r.$element.val(t), r.$element.trigger("input").trigger("change")
                    })
                }
            }, n.prototype.bind = function (e, t) {
                var n = this;
                (this.container = e).on("select", function (e) {
                    n.select(e.data)
                }), e.on("unselect", function (e) {
                    n.unselect(e.data)
                })
            }, n.prototype.destroy = function () {
                this.$element.find("*").each(function () {
                    a.RemoveData(this)
                })
            }, n.prototype.query = function (t, e) {
                var n = [], s = this;
                this.$element.children().each(function () {
                    var e;
                    "option" !== this.tagName.toLowerCase() && "optgroup" !== this.tagName.toLowerCase() || (e = l(this), e = s.item(e), null !== (e = s.matches(t, e)) && n.push(e))
                }), e({results: n})
            }, n.prototype.addOptions = function (e) {
                this.$element.append(e)
            }, n.prototype.option = function (e) {
                var t;
                e.children ? (t = document.createElement("optgroup")).label = e.text : void 0 !== (t = document.createElement("option")).textContent ? t.textContent = e.text : t.innerText = e.text, void 0 !== e.id && (t.value = e.id), e.disabled && (t.disabled = !0), e.selected && (t.selected = !0), e.title && (t.title = e.title);
                e = this._normalizeItem(e);
                return e.element = t, a.StoreData(t, "data", e), l(t)
            }, n.prototype.item = function (e) {
                var t = {};
                if (null != (t = a.GetData(e[0], "data"))) return t;
                var n = e[0];
                if ("option" === n.tagName.toLowerCase()) t = {
                    id: e.val(),
                    text: e.text(),
                    disabled: e.prop("disabled"),
                    selected: e.prop("selected"),
                    title: e.prop("title")
                }; else if ("optgroup" === n.tagName.toLowerCase()) {
                    t = {text: e.prop("label"), children: [], title: e.prop("title")};
                    for (var s = e.children("option"), i = [], r = 0; r < s.length; r++) {
                        var o = l(s[r]), o = this.item(o);
                        i.push(o)
                    }
                    t.children = i
                }
                return (t = this._normalizeItem(t)).element = e[0], a.StoreData(e[0], "data", t), t
            }, n.prototype._normalizeItem = function (e) {
                e !== Object(e) && (e = {id: e, text: e});
                return null != (e = l.extend({}, {text: ""}, e)).id && (e.id = e.id.toString()), null != e.text && (e.text = e.text.toString()), null == e._resultId && e.id && null != this.container && (e._resultId = this.generateResultId(this.container, e)), l.extend({}, {
                    selected: !1,
                    disabled: !1
                }, e)
            }, n.prototype.matches = function (e, t) {
                return this.options.get("matcher")(e, t)
            }, n
        }), u.define("select2/data/array", ["./select", "../utils", "jquery"], function (e, t, c) {
            function s(e, t) {
                this._dataToConvert = t.get("data") || [], s.__super__.constructor.call(this, e, t)
            }

            return t.Extend(s, e), s.prototype.bind = function (e, t) {
                s.__super__.bind.call(this, e, t), this.addOptions(this.convertToOptions(this._dataToConvert))
            }, s.prototype.select = function (n) {
                var e = this.$element.find("option").filter(function (e, t) {
                    return t.value == n.id.toString()
                });
                0 === e.length && (e = this.option(n), this.addOptions(e)), s.__super__.select.call(this, n)
            }, s.prototype.convertToOptions = function (e) {
                var t = this, n = this.$element.find("option"), s = n.map(function () {
                    return t.item(c(this)).id
                }).get(), i = [];
                for (var r = 0; r < e.length; r++) {
                    var o, a, l = this._normalizeItem(e[r]);
                    0 <= s.indexOf(l.id) ? (o = n.filter(function (e) {
                        return function () {
                            return c(this).val() == e.id
                        }
                    }(l)), a = this.item(o), a = c.extend(!0, {}, l, a), a = this.option(a), o.replaceWith(a)) : (a = this.option(l), l.children && (l = this.convertToOptions(l.children), a.append(l)), i.push(a))
                }
                return i
            }, s
        }), u.define("select2/data/ajax", ["./array", "../utils", "jquery"], function (e, t, r) {
            function n(e, t) {
                this.ajaxOptions = this._applyDefaults(t.get("ajax")), null != this.ajaxOptions.processResults && (this.processResults = this.ajaxOptions.processResults), n.__super__.constructor.call(this, e, t)
            }

            return t.Extend(n, e), n.prototype._applyDefaults = function (e) {
                var t = {
                    data: function (e) {
                        return r.extend({}, e, {q: e.term})
                    }, transport: function (e, t, n) {
                        e = r.ajax(e);
                        return e.then(t), e.fail(n), e
                    }
                };
                return r.extend({}, t, e, !0)
            }, n.prototype.processResults = function (e) {
                return e
            }, n.prototype.query = function (t, n) {
                var s = this;
                null != this._request && ("function" == typeof this._request.abort && this._request.abort(), this._request = null);
                var i = r.extend({type: "GET"}, this.ajaxOptions);

                function e() {
                    var e = i.transport(i, function (e) {
                        e = s.processResults(e, t);
                        s.options.get("debug") && window.console && console.error && (e && e.results && Array.isArray(e.results) || console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")), n(e)
                    }, function () {
                        "status" in e && (0 === e.status || "0" === e.status) || s.trigger("results:message", {message: "errorLoading"})
                    });
                    s._request = e
                }

                "function" == typeof i.url && (i.url = i.url.call(this.$element, t)), "function" == typeof i.data && (i.data = i.data.call(this.$element, t)), this.ajaxOptions.delay && null != t.term ? (this._queryTimeout && window.clearTimeout(this._queryTimeout), this._queryTimeout = window.setTimeout(e, this.ajaxOptions.delay)) : e()
            }, n
        }), u.define("select2/data/tags", ["jquery"], function (t) {
            function e(e, t, n) {
                var s = n.get("tags"), i = n.get("createTag");
                void 0 !== i && (this.createTag = i);
                i = n.get("insertTag");
                if (void 0 !== i && (this.insertTag = i), e.call(this, t, n), Array.isArray(s)) for (var r = 0; r < s.length; r++) {
                    var o = s[r], o = this._normalizeItem(o), o = this.option(o);
                    this.$element.append(o)
                }
            }

            return e.prototype.query = function (e, c, u) {
                var d = this;
                this._removeOldTags(), null != c.term && null == c.page ? e.call(this, c, function e(t, n) {
                    for (var s = t.results, i = 0; i < s.length; i++) {
                        var r = s[i], o = null != r.children && !e({results: r.children}, !0);
                        if ((r.text || "").toUpperCase() === (c.term || "").toUpperCase() || o) return !n && (t.data = s, void u(t))
                    }
                    if (n) return !0;
                    var a, l = d.createTag(c);
                    null != l && ((a = d.option(l)).attr("data-select2-tag", "true"), d.addOptions([a]), d.insertTag(s, l)), t.results = s, u(t)
                }) : e.call(this, c, u)
            }, e.prototype.createTag = function (e, t) {
                if (null == t.term) return null;
                t = t.term.trim();
                return "" === t ? null : {id: t, text: t}
            }, e.prototype.insertTag = function (e, t, n) {
                t.unshift(n)
            }, e.prototype._removeOldTags = function (e) {
                this.$element.find("option[data-select2-tag]").each(function () {
                    this.selected || t(this).remove()
                })
            }, e
        }), u.define("select2/data/tokenizer", ["jquery"], function (c) {
            function e(e, t, n) {
                var s = n.get("tokenizer");
                void 0 !== s && (this.tokenizer = s), e.call(this, t, n)
            }

            return e.prototype.bind = function (e, t, n) {
                e.call(this, t, n), this.$search = t.dropdown.$search || t.selection.$search || n.find(".select2-search__field")
            }, e.prototype.query = function (e, t, n) {
                var s = this;
                t.term = t.term || "";
                var i = this.tokenizer(t, this.options, function (e) {
                    var t, n = s._normalizeItem(e);
                    s.$element.find("option").filter(function () {
                        return c(this).val() === n.id
                    }).length || ((t = s.option(n)).attr("data-select2-tag", !0), s._removeOldTags(), s.addOptions([t])), t = n, s.trigger("select", {data: t})
                });
                i.term !== t.term && (this.$search.length && (this.$search.val(i.term), this.$search.trigger("focus")), t.term = i.term), e.call(this, t, n)
            }, e.prototype.tokenizer = function (e, t, n, s) {
                for (var i = n.get("tokenSeparators") || [], r = t.term, o = 0, a = this.createTag || function (e) {
                    return {id: e.term, text: e.term}
                }; o < r.length;) {
                    var l = r[o];
                    -1 !== i.indexOf(l) ? (l = r.substr(0, o), null != (l = a(c.extend({}, t, {term: l}))) ? (s(l), r = r.substr(o+1) || "", o = 0) : o++) : o++
                }
                return {term: r}
            }, e
        }), u.define("select2/data/minimumInputLength", [], function () {
            function e(e, t, n) {
                this.minimumInputLength = n.get("minimumInputLength"), e.call(this, t, n)
            }

            return e.prototype.query = function (e, t, n) {
                t.term = t.term || "", t.term.length < this.minimumInputLength ? this.trigger("results:message", {
                    message: "inputTooShort",
                    args: {minimum: this.minimumInputLength, input: t.term, params: t}
                }) : e.call(this, t, n)
            }, e
        }), u.define("select2/data/maximumInputLength", [], function () {
            function e(e, t, n) {
                this.maximumInputLength = n.get("maximumInputLength"), e.call(this, t, n)
            }

            return e.prototype.query = function (e, t, n) {
                t.term = t.term || "", 0 < this.maximumInputLength && t.term.length > this.maximumInputLength ? this.trigger("results:message", {
                    message: "inputTooLong",
                    args: {maximum: this.maximumInputLength, input: t.term, params: t}
                }) : e.call(this, t, n)
            }, e
        }), u.define("select2/data/maximumSelectionLength", [], function () {
            function e(e, t, n) {
                this.maximumSelectionLength = n.get("maximumSelectionLength"), e.call(this, t, n)
            }

            return e.prototype.bind = function (e, t, n) {
                var s = this;
                e.call(this, t, n), t.on("select", function () {
                    s._checkIfMaximumSelected()
                })
            }, e.prototype.query = function (e, t, n) {
                var s = this;
                this._checkIfMaximumSelected(function () {
                    e.call(s, t, n)
                })
            }, e.prototype._checkIfMaximumSelected = function (e, t) {
                var n = this;
                this.current(function (e) {
                    e = null != e ? e.length : 0;
                    0 < n.maximumSelectionLength && e >= n.maximumSelectionLength ? n.trigger("results:message", {
                        message: "maximumSelected",
                        args: {maximum: n.maximumSelectionLength}
                    }) : t && t()
                })
            }, e
        }), u.define("select2/dropdown", ["jquery", "./utils"], function (t, e) {
            function n(e, t) {
                this.$element = e, this.options = t, n.__super__.constructor.call(this)
            }

            return e.Extend(n, e.Observable), n.prototype.render = function () {
                var e = t('<span class="select2-dropdown"><span class="select2-results"></span></span>');
                return e.attr("dir", this.options.get("dir")), this.$dropdown = e
            }, n.prototype.bind = function () {
            }, n.prototype.position = function (e, t) {
            }, n.prototype.destroy = function () {
                this.$dropdown.remove()
            }, n
        }), u.define("select2/dropdown/search", ["jquery"], function (r) {
            function e() {
            }

            return e.prototype.render = function (e) {
                var t = e.call(this), n = this.options.get("translations").get("search"),
                    e = r('<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" /></span>');
                return this.$searchContainer = e, this.$search = e.find("input"), this.$search.prop("autocomplete", this.options.get("autocomplete")), this.$search.attr("aria-label", n()), t.prepend(e), t
            }, e.prototype.bind = function (e, t, n) {
                var s = this, i = t.id+"-results";
                e.call(this, t, n), this.$search.on("keydown", function (e) {
                    s.trigger("keypress", e), s._keyUpPrevented = e.isDefaultPrevented()
                }), this.$search.on("input", function (e) {
                    r(this).off("keyup")
                }), this.$search.on("keyup input", function (e) {
                    s.handleSearch(e)
                }), t.on("open", function () {
                    s.$search.attr("tabindex", 0), s.$search.attr("aria-controls", i), s.$search.trigger("focus"), window.setTimeout(function () {
                        s.$search.trigger("focus")
                    }, 0)
                }), t.on("close", function () {
                    s.$search.attr("tabindex", -1), s.$search.removeAttr("aria-controls"), s.$search.removeAttr("aria-activedescendant"), s.$search.val(""), s.$search.trigger("blur")
                }), t.on("focus", function () {
                    t.isOpen() || s.$search.trigger("focus")
                }), t.on("results:all", function (e) {
                    null != e.query.term && "" !== e.query.term || (s.showSearch(e) ? s.$searchContainer[0].classList.remove("select2-search--hide") : s.$searchContainer[0].classList.add("select2-search--hide"))
                }), t.on("results:focus", function (e) {
                    e.data._resultId ? s.$search.attr("aria-activedescendant", e.data._resultId) : s.$search.removeAttr("aria-activedescendant")
                })
            }, e.prototype.handleSearch = function (e) {
                var t;
                this._keyUpPrevented || (t = this.$search.val(), this.trigger("query", {term: t})), this._keyUpPrevented = !1
            }, e.prototype.showSearch = function (e, t) {
                return !0
            }, e
        }), u.define("select2/dropdown/hidePlaceholder", [], function () {
            function e(e, t, n, s) {
                this.placeholder = this.normalizePlaceholder(n.get("placeholder")), e.call(this, t, n, s)
            }

            return e.prototype.append = function (e, t) {
                t.results = this.removePlaceholder(t.results), e.call(this, t)
            }, e.prototype.normalizePlaceholder = function (e, t) {
                return t = "string" == typeof t ? {id: "", text: t} : t
            }, e.prototype.removePlaceholder = function (e, t) {
                for (var n = t.slice(0), s = t.length-1; 0 <= s; s--) {
                    var i = t[s];
                    this.placeholder.id === i.id && n.splice(s, 1)
                }
                return n
            }, e
        }), u.define("select2/dropdown/infiniteScroll", ["jquery"], function (n) {
            function e(e, t, n, s) {
                this.lastParams = {}, e.call(this, t, n, s), this.$loadingMore = this.createLoadingMore(), this.loading = !1
            }

            return e.prototype.append = function (e, t) {
                this.$loadingMore.remove(), this.loading = !1, e.call(this, t), this.showLoadingMore(t) && (this.$results.append(this.$loadingMore), this.loadMoreIfNeeded())
            }, e.prototype.bind = function (e, t, n) {
                var s = this;
                e.call(this, t, n), t.on("query", function (e) {
                    s.lastParams = e, s.loading = !0
                }), t.on("query:append", function (e) {
                    s.lastParams = e, s.loading = !0
                }), this.$results.on("scroll", this.loadMoreIfNeeded.bind(this))
            }, e.prototype.loadMoreIfNeeded = function () {
                var e = n.contains(document.documentElement, this.$loadingMore[0]);
                !this.loading && e && (e = this.$results.offset().top+this.$results.outerHeight(!1), this.$loadingMore.offset().top+this.$loadingMore.outerHeight(!1) <= e+50 && this.loadMore())
            }, e.prototype.loadMore = function () {
                this.loading = !0;
                var e = n.extend({}, {page: 1}, this.lastParams);
                e.page++, this.trigger("query:append", e)
            }, e.prototype.showLoadingMore = function (e, t) {
                return t.pagination && t.pagination.more
            }, e.prototype.createLoadingMore = function () {
                var e = n('<li class="select2-results__option select2-results__option--load-more"role="option" aria-disabled="true"></li>'),
                    t = this.options.get("translations").get("loadingMore");
                return e.html(t(this.lastParams)), e
            }, e
        }), u.define("select2/dropdown/attachBody", ["jquery", "../utils"], function (u, o) {
            function e(e, t, n) {
                this.$dropdownParent = u(n.get("dropdownParent") || document.body), e.call(this, t, n)
            }

            return e.prototype.bind = function (e, t, n) {
                var s = this;
                e.call(this, t, n), t.on("open", function () {
                    s._showDropdown(), s._attachPositioningHandler(t), s._bindContainerResultHandlers(t)
                }), t.on("close", function () {
                    s._hideDropdown(), s._detachPositioningHandler(t)
                }), this.$dropdownContainer.on("mousedown", function (e) {
                    e.stopPropagation()
                })
            }, e.prototype.destroy = function (e) {
                e.call(this), this.$dropdownContainer.remove()
            }, e.prototype.position = function (e, t, n) {
                t.attr("class", n.attr("class")), t[0].classList.remove("select2"), t[0].classList.add("select2-container--open"), t.css({
                    position: "absolute",
                    top: -999999
                }), this.$container = n
            }, e.prototype.render = function (e) {
                var t = u("<span></span>"), e = e.call(this);
                return t.append(e), this.$dropdownContainer = t
            }, e.prototype._hideDropdown = function (e) {
                this.$dropdownContainer.detach()
            }, e.prototype._bindContainerResultHandlers = function (e, t) {
                var n;
                this._containerResultsHandlersBound || (n = this, t.on("results:all", function () {
                    n._positionDropdown(), n._resizeDropdown()
                }), t.on("results:append", function () {
                    n._positionDropdown(), n._resizeDropdown()
                }), t.on("results:message", function () {
                    n._positionDropdown(), n._resizeDropdown()
                }), t.on("select", function () {
                    n._positionDropdown(), n._resizeDropdown()
                }), t.on("unselect", function () {
                    n._positionDropdown(), n._resizeDropdown()
                }), this._containerResultsHandlersBound = !0)
            }, e.prototype._attachPositioningHandler = function (e, t) {
                var n = this, s = "scroll.select2."+t.id, i = "resize.select2."+t.id,
                    r = "orientationchange.select2."+t.id, t = this.$container.parents().filter(o.hasScroll);
                t.each(function () {
                    o.StoreData(this, "select2-scroll-position", {x: u(this).scrollLeft(), y: u(this).scrollTop()})
                }), t.on(s, function (e) {
                    var t = o.GetData(this, "select2-scroll-position");
                    u(this).scrollTop(t.y)
                }), u(window).on(s+" "+i+" "+r, function (e) {
                    n._positionDropdown(), n._resizeDropdown()
                })
            }, e.prototype._detachPositioningHandler = function (e, t) {
                var n = "scroll.select2."+t.id, s = "resize.select2."+t.id, t = "orientationchange.select2."+t.id;
                this.$container.parents().filter(o.hasScroll).off(n), u(window).off(n+" "+s+" "+t)
            }, e.prototype._positionDropdown = function () {
                var e = u(window), t = this.$dropdown[0].classList.contains("select2-dropdown--above"),
                    n = this.$dropdown[0].classList.contains("select2-dropdown--below"), s = null,
                    i = this.$container.offset();
                i.bottom = i.top+this.$container.outerHeight(!1);
                var r = {height: this.$container.outerHeight(!1)};
                r.top = i.top, r.bottom = i.top+r.height;
                var o = this.$dropdown.outerHeight(!1), a = e.scrollTop(), l = e.scrollTop()+e.height(),
                    c = a < i.top-o, e = l > i.bottom+o, a = {left: i.left, top: r.bottom}, l = this.$dropdownParent;
                "static" === l.css("position") && (l = l.offsetParent());
                i = {top: 0, left: 0};
                (u.contains(document.body, l[0]) || l[0].isConnected) && (i = l.offset()), a.top -= i.top, a.left -= i.left, t || n || (s = "below"), e || !c || t ? !c && e && t && (s = "below") : s = "above", ("above" == s || t && "below" !== s) && (a.top = r.top-i.top-o), null != s && (this.$dropdown[0].classList.remove("select2-dropdown--below"), this.$dropdown[0].classList.remove("select2-dropdown--above"), this.$dropdown[0].classList.add("select2-dropdown--"+s), this.$container[0].classList.remove("select2-container--below"), this.$container[0].classList.remove("select2-container--above"), this.$container[0].classList.add("select2-container--"+s)), this.$dropdownContainer.css(a)
            }, e.prototype._resizeDropdown = function () {
                var e = {width: this.$container.outerWidth(!1)+"px"};
                this.options.get("dropdownAutoWidth") && (e.minWidth = e.width, e.position = "relative", e.width = "auto"), this.$dropdown.css(e)
            }, e.prototype._showDropdown = function (e) {
                this.$dropdownContainer.appendTo(this.$dropdownParent), this._positionDropdown(), this._resizeDropdown()
            }, e
        }), u.define("select2/dropdown/minimumResultsForSearch", [], function () {
            function e(e, t, n, s) {
                this.minimumResultsForSearch = n.get("minimumResultsForSearch"), this.minimumResultsForSearch < 0 && (this.minimumResultsForSearch = 1 / 0), e.call(this, t, n, s)
            }

            return e.prototype.showSearch = function (e, t) {
                return !(function e(t) {
                    for (var n = 0, s = 0; s < t.length; s++) {
                        var i = t[s];
                        i.children ? n += e(i.children) : n++
                    }
                    return n
                }(t.data.results) < this.minimumResultsForSearch) && e.call(this, t)
            }, e
        }), u.define("select2/dropdown/selectOnClose", ["../utils"], function (s) {
            function e() {
            }

            return e.prototype.bind = function (e, t, n) {
                var s = this;
                e.call(this, t, n), t.on("close", function (e) {
                    s._handleSelectOnClose(e)
                })
            }, e.prototype._handleSelectOnClose = function (e, t) {
                if (t && null != t.originalSelect2Event) {
                    var n = t.originalSelect2Event;
                    if ("select" === n._type || "unselect" === n._type) return
                }
                n = this.getHighlightedResults();
                n.length < 1 || (null != (n = s.GetData(n[0], "data")).element && n.element.selected || null == n.element && n.selected || this.trigger("select", {data: n}))
            }, e
        }), u.define("select2/dropdown/closeOnSelect", [], function () {
            function e() {
            }

            return e.prototype.bind = function (e, t, n) {
                var s = this;
                e.call(this, t, n), t.on("select", function (e) {
                    s._selectTriggered(e)
                }), t.on("unselect", function (e) {
                    s._selectTriggered(e)
                })
            }, e.prototype._selectTriggered = function (e, t) {
                var n = t.originalEvent;
                n && (n.ctrlKey || n.metaKey) || this.trigger("close", {originalEvent: n, originalSelect2Event: t})
            }, e
        }), u.define("select2/dropdown/dropdownCss", ["../utils"], function (n) {
            function e() {
            }

            return e.prototype.render = function (e) {
                var t = e.call(this), e = this.options.get("dropdownCssClass") || "";
                return -1 !== e.indexOf(":all:") && (e = e.replace(":all:", ""), n.copyNonInternalCssClasses(t[0], this.$element[0])), t.addClass(e), t
            }, e
        }), u.define("select2/dropdown/tagsSearchHighlight", ["../utils"], function (s) {
            function e() {
            }

            return e.prototype.highlightFirstItem = function (e) {
                var t = this.$results.find(".select2-results__option--selectable:not(.select2-results__option--selected)");
                if (0 < t.length) {
                    var n = t.first(), t = s.GetData(n[0], "data").element;
                    if (t && t.getAttribute && "true" === t.getAttribute("data-select2-tag")) return void n.trigger("mouseenter")
                }
                e.call(this)
            }, e
        }), u.define("select2/i18n/en", [], function () {
            return {
                errorLoading: function () {
                    return "The results could not be loaded."
                }, inputTooLong: function (e) {
                    var t = e.input.length-e.maximum, e = "Please delete "+t+" character";
                    return 1 != t && (e += "s"), e
                }, inputTooShort: function (e) {
                    return "Please enter "+(e.minimum-e.input.length)+" or more characters"
                }, loadingMore: function () {
                    return "Loading more results…"
                }, maximumSelected: function (e) {
                    var t = "You can only select "+e.maximum+" item";
                    return 1 != e.maximum && (t += "s"), t
                }, noResults: function () {
                    return "No results found"
                }, searching: function () {
                    return "Searching…"
                }, removeAllItems: function () {
                    return "Remove all items"
                }, removeItem: function () {
                    return "Remove item"
                }, search: function () {
                    return "Search"
                }
            }
        }), u.define("select2/defaults", ["jquery", "./results", "./selection/single", "./selection/multiple", "./selection/placeholder", "./selection/allowClear", "./selection/search", "./selection/selectionCss", "./selection/eventRelay", "./utils", "./translation", "./diacritics", "./data/select", "./data/array", "./data/ajax", "./data/tags", "./data/tokenizer", "./data/minimumInputLength", "./data/maximumInputLength", "./data/maximumSelectionLength", "./dropdown", "./dropdown/search", "./dropdown/hidePlaceholder", "./dropdown/infiniteScroll", "./dropdown/attachBody", "./dropdown/minimumResultsForSearch", "./dropdown/selectOnClose", "./dropdown/closeOnSelect", "./dropdown/dropdownCss", "./dropdown/tagsSearchHighlight", "./i18n/en"], function (l, r, o, a, c, u, d, p, h, f, g, t, m, y, v, _, b, $, w, x, A, D, S, E, O, C, L, T, q, I, e) {
            function n() {
                this.reset()
            }

            return n.prototype.apply = function (e) {
                var t;
                null == (e = l.extend(!0, {}, this.defaults, e)).dataAdapter && (null != e.ajax ? e.dataAdapter = v : null != e.data ? e.dataAdapter = y : e.dataAdapter = m, 0 < e.minimumInputLength && (e.dataAdapter = f.Decorate(e.dataAdapter, $)), 0 < e.maximumInputLength && (e.dataAdapter = f.Decorate(e.dataAdapter, w)), 0 < e.maximumSelectionLength && (e.dataAdapter = f.Decorate(e.dataAdapter, x)), e.tags && (e.dataAdapter = f.Decorate(e.dataAdapter, _)), null == e.tokenSeparators && null == e.tokenizer || (e.dataAdapter = f.Decorate(e.dataAdapter, b))), null == e.resultsAdapter && (e.resultsAdapter = r, null != e.ajax && (e.resultsAdapter = f.Decorate(e.resultsAdapter, E)), null != e.placeholder && (e.resultsAdapter = f.Decorate(e.resultsAdapter, S)), e.selectOnClose && (e.resultsAdapter = f.Decorate(e.resultsAdapter, L)), e.tags && (e.resultsAdapter = f.Decorate(e.resultsAdapter, I))), null == e.dropdownAdapter && (e.multiple ? e.dropdownAdapter = A : (t = f.Decorate(A, D), e.dropdownAdapter = t), 0 !== e.minimumResultsForSearch && (e.dropdownAdapter = f.Decorate(e.dropdownAdapter, C)), e.closeOnSelect && (e.dropdownAdapter = f.Decorate(e.dropdownAdapter, T)), null != e.dropdownCssClass && (e.dropdownAdapter = f.Decorate(e.dropdownAdapter, q)), e.dropdownAdapter = f.Decorate(e.dropdownAdapter, O)), null == e.selectionAdapter && (e.multiple ? e.selectionAdapter = a : e.selectionAdapter = o, null != e.placeholder && (e.selectionAdapter = f.Decorate(e.selectionAdapter, c)), e.allowClear && (e.selectionAdapter = f.Decorate(e.selectionAdapter, u)), e.multiple && (e.selectionAdapter = f.Decorate(e.selectionAdapter, d)), null != e.selectionCssClass && (e.selectionAdapter = f.Decorate(e.selectionAdapter, p)), e.selectionAdapter = f.Decorate(e.selectionAdapter, h)), e.language = this._resolveLanguage(e.language), e.language.push("en");
                for (var n = [], s = 0; s < e.language.length; s++) {
                    var i = e.language[s];
                    -1 === n.indexOf(i) && n.push(i)
                }
                return e.language = n, e.translations = this._processTranslations(e.language, e.debug), e
            }, n.prototype.reset = function () {
                function a(e) {
                    return e.replace(/[^\u0000-\u007E]/g, function (e) {
                        return t[e] || e
                    })
                }

                this.defaults = {
                    amdLanguageBase: "./i18n/",
                    autocomplete: "off",
                    closeOnSelect: !0,
                    debug: !1,
                    dropdownAutoWidth: !1,
                    escapeMarkup: f.escapeMarkup,
                    language: {},
                    matcher: function e(t, n) {
                        if (null == t.term || "" === t.term.trim()) return n;
                        if (n.children && 0 < n.children.length) {
                            for (var s = l.extend(!0, {}, n), i = n.children.length-1; 0 <= i; i--) null == e(t, n.children[i]) && s.children.splice(i, 1);
                            return 0 < s.children.length ? s : e(t, s)
                        }
                        var r = a(n.text).toUpperCase(), o = a(t.term).toUpperCase();
                        return -1 < r.indexOf(o) ? n : null
                    },
                    minimumInputLength: 0,
                    maximumInputLength: 0,
                    maximumSelectionLength: 0,
                    minimumResultsForSearch: 0,
                    selectOnClose: !1,
                    scrollAfterSelect: !1,
                    sorter: function (e) {
                        return e
                    },
                    templateResult: function (e) {
                        return e.text
                    },
                    templateSelection: function (e) {
                        return e.text
                    },
                    theme: "default",
                    width: "resolve"
                }
            }, n.prototype.applyFromElement = function (e, t) {
                var n = e.language, s = this.defaults.language, i = t.prop("lang"),
                    t = t.closest("[lang]").prop("lang"),
                    t = Array.prototype.concat.call(this._resolveLanguage(i), this._resolveLanguage(n), this._resolveLanguage(s), this._resolveLanguage(t));
                return e.language = t, e
            }, n.prototype._resolveLanguage = function (e) {
                if (!e) return [];
                if (l.isEmptyObject(e)) return [];
                if (l.isPlainObject(e)) return [e];
                for (var t, n = Array.isArray(e) ? e : [e], s = [], i = 0; i < n.length; i++) s.push(n[i]), "string" == typeof n[i] && 0 < n[i].indexOf("-") && (t = n[i].split("-")[0], s.push(t));
                return s
            }, n.prototype._processTranslations = function (e, t) {
                for (var n = new g, s = 0; s < e.length; s++) {
                    var i = new g, r = e[s];
                    if ("string" == typeof r) try {
                        i = g.loadPath(r)
                    } catch (e) {
                        try {
                            r = this.defaults.amdLanguageBase+r, i = g.loadPath(r)
                        } catch (e) {
                            t && window.console && console.warn && console.warn('Select2: The language file for "'+r+'" could not be automatically loaded. A fallback will be used instead.')
                        }
                    } else i = l.isPlainObject(r) ? new g(r) : r;
                    n.extend(i)
                }
                return n
            }, n.prototype.set = function (e, t) {
                var n = {};
                n[l.camelCase(e)] = t;
                n = f._convertData(n);
                l.extend(!0, this.defaults, n)
            }, new n
        }), u.define("select2/options", ["jquery", "./defaults", "./utils"], function (c, n, u) {
            function e(e, t) {
                this.options = e, null != t && this.fromElement(t), null != t && (this.options = n.applyFromElement(this.options, t)), this.options = n.apply(this.options)
            }

            return e.prototype.fromElement = function (e) {
                var t = ["select2"];
                null == this.options.multiple && (this.options.multiple = e.prop("multiple")), null == this.options.disabled && (this.options.disabled = e.prop("disabled")), null == this.options.autocomplete && e.prop("autocomplete") && (this.options.autocomplete = e.prop("autocomplete")), null == this.options.dir && (e.prop("dir") ? this.options.dir = e.prop("dir") : e.closest("[dir]").prop("dir") ? this.options.dir = e.closest("[dir]").prop("dir") : this.options.dir = "ltr"), e.prop("disabled", this.options.disabled), e.prop("multiple", this.options.multiple), u.GetData(e[0], "select2Tags") && (this.options.debug && window.console && console.warn && console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'), u.StoreData(e[0], "data", u.GetData(e[0], "select2Tags")), u.StoreData(e[0], "tags", !0)), u.GetData(e[0], "ajaxUrl") && (this.options.debug && window.console && console.warn && console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."), e.attr("ajax--url", u.GetData(e[0], "ajaxUrl")), u.StoreData(e[0], "ajax-Url", u.GetData(e[0], "ajaxUrl")));
                var n = {};

                function s(e, t) {
                    return t.toUpperCase()
                }

                for (var i = 0; i < e[0].attributes.length; i++) {
                    var r = e[0].attributes[i].name, o = "data-";
                    r.substr(0, o.length) == o && (r = r.substring(o.length), o = u.GetData(e[0], r), n[r.replace(/-([a-z])/g, s)] = o)
                }
                c.fn.jquery && "1." == c.fn.jquery.substr(0, 2) && e[0].dataset && (n = c.extend(!0, {}, e[0].dataset, n));
                var a, l = c.extend(!0, {}, u.GetData(e[0]), n);
                for (a in l = u._convertData(l)) -1 < t.indexOf(a) || (c.isPlainObject(this.options[a]) ? c.extend(this.options[a], l[a]) : this.options[a] = l[a]);
                return this
            }, e.prototype.get = function (e) {
                return this.options[e]
            }, e.prototype.set = function (e, t) {
                this.options[e] = t
            }, e
        }), u.define("select2/core", ["jquery", "./options", "./utils", "./keys"], function (t, i, r, s) {
            var o = function (e, t) {
                null != r.GetData(e[0], "select2") && r.GetData(e[0], "select2").destroy(), this.$element = e, this.id = this._generateId(e), t = t || {}, this.options = new i(t, e), o.__super__.constructor.call(this);
                var n = e.attr("tabindex") || 0;
                r.StoreData(e[0], "old-tabindex", n), e.attr("tabindex", "-1");
                t = this.options.get("dataAdapter");
                this.dataAdapter = new t(e, this.options);
                n = this.render();
                this._placeContainer(n);
                t = this.options.get("selectionAdapter");
                this.selection = new t(e, this.options), this.$selection = this.selection.render(), this.selection.position(this.$selection, n);
                t = this.options.get("dropdownAdapter");
                this.dropdown = new t(e, this.options), this.$dropdown = this.dropdown.render(), this.dropdown.position(this.$dropdown, n);
                n = this.options.get("resultsAdapter");
                this.results = new n(e, this.options, this.dataAdapter), this.$results = this.results.render(), this.results.position(this.$results, this.$dropdown);
                var s = this;
                this._bindAdapters(), this._registerDomEvents(), this._registerDataEvents(), this._registerSelectionEvents(), this._registerDropdownEvents(), this._registerResultsEvents(), this._registerEvents(), this.dataAdapter.current(function (e) {
                    s.trigger("selection:update", {data: e})
                }), e[0].classList.add("select2-hidden-accessible"), e.attr("aria-hidden", "true"), this._syncAttributes(), r.StoreData(e[0], "select2", this), e.data("select2", this)
            };
            return r.Extend(o, r.Observable), o.prototype._generateId = function (e) {
                return "select2-"+(null != e.attr("id") ? e.attr("id") : null != e.attr("name") ? e.attr("name")+"-"+r.generateChars(2) : r.generateChars(4)).replace(/(:|\.|\[|\]|,)/g, "")
            }, o.prototype._placeContainer = function (e) {
                e.insertAfter(this.$element);
                var t = this._resolveWidth(this.$element, this.options.get("width"));
                null != t && e.css("width", t)
            }, o.prototype._resolveWidth = function (e, t) {
                var n = /^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;
                if ("resolve" == t) {
                    var s = this._resolveWidth(e, "style");
                    return null != s ? s : this._resolveWidth(e, "element")
                }
                if ("element" == t) {
                    s = e.outerWidth(!1);
                    return s <= 0 ? "auto" : s+"px"
                }
                if ("style" != t) return "computedstyle" != t ? t : window.getComputedStyle(e[0]).width;
                e = e.attr("style");
                if ("string" != typeof e) return null;
                for (var i = e.split(";"), r = 0, o = i.length; r < o; r += 1) {
                    var a = i[r].replace(/\s/g, "").match(n);
                    if (null !== a && 1 <= a.length) return a[1]
                }
                return null
            }, o.prototype._bindAdapters = function () {
                this.dataAdapter.bind(this, this.$container), this.selection.bind(this, this.$container), this.dropdown.bind(this, this.$container), this.results.bind(this, this.$container)
            }, o.prototype._registerDomEvents = function () {
                var t = this;
                this.$element.on("change.select2", function () {
                    t.dataAdapter.current(function (e) {
                        t.trigger("selection:update", {data: e})
                    })
                }), this.$element.on("focus.select2", function (e) {
                    t.trigger("focus", e)
                }), this._syncA = r.bind(this._syncAttributes, this), this._syncS = r.bind(this._syncSubtree, this), this._observer = new window.MutationObserver(function (e) {
                    t._syncA(), t._syncS(e)
                }), this._observer.observe(this.$element[0], {attributes: !0, childList: !0, subtree: !1})
            }, o.prototype._registerDataEvents = function () {
                var n = this;
                this.dataAdapter.on("*", function (e, t) {
                    n.trigger(e, t)
                })
            }, o.prototype._registerSelectionEvents = function () {
                var n = this, s = ["toggle", "focus"];
                this.selection.on("toggle", function () {
                    n.toggleDropdown()
                }), this.selection.on("focus", function (e) {
                    n.focus(e)
                }), this.selection.on("*", function (e, t) {
                    -1 === s.indexOf(e) && n.trigger(e, t)
                })
            }, o.prototype._registerDropdownEvents = function () {
                var n = this;
                this.dropdown.on("*", function (e, t) {
                    n.trigger(e, t)
                })
            }, o.prototype._registerResultsEvents = function () {
                var n = this;
                this.results.on("*", function (e, t) {
                    n.trigger(e, t)
                })
            }, o.prototype._registerEvents = function () {
                var n = this;
                this.on("open", function () {
                    n.$container[0].classList.add("select2-container--open")
                }), this.on("close", function () {
                    n.$container[0].classList.remove("select2-container--open")
                }), this.on("enable", function () {
                    n.$container[0].classList.remove("select2-container--disabled")
                }), this.on("disable", function () {
                    n.$container[0].classList.add("select2-container--disabled")
                }), this.on("blur", function () {
                    n.$container[0].classList.remove("select2-container--focus")
                }), this.on("query", function (t) {
                    n.isOpen() || n.trigger("open", {}), this.dataAdapter.query(t, function (e) {
                        n.trigger("results:all", {data: e, query: t})
                    })
                }), this.on("query:append", function (t) {
                    this.dataAdapter.query(t, function (e) {
                        n.trigger("results:append", {data: e, query: t})
                    })
                }), this.on("keypress", function (e) {
                    var t = e.which;
                    n.isOpen() ? t === s.ESC || t === s.UP && e.altKey ? (n.close(e), e.preventDefault()) : t === s.ENTER || t === s.TAB ? (n.trigger("results:select", {}), e.preventDefault()) : t === s.SPACE && e.ctrlKey ? (n.trigger("results:toggle", {}), e.preventDefault()) : t === s.UP ? (n.trigger("results:previous", {}), e.preventDefault()) : t === s.DOWN && (n.trigger("results:next", {}), e.preventDefault()) : (t === s.ENTER || t === s.SPACE || t === s.DOWN && e.altKey) && (n.open(), e.preventDefault())
                })
            }, o.prototype._syncAttributes = function () {
                this.options.set("disabled", this.$element.prop("disabled")), this.isDisabled() ? (this.isOpen() && this.close(), this.trigger("disable", {})) : this.trigger("enable", {})
            }, o.prototype._isChangeMutation = function (e) {
                var t = this;
                if (e.addedNodes && 0 < e.addedNodes.length) {
                    for (var n = 0; n < e.addedNodes.length; n++) if (e.addedNodes[n].selected) return !0
                } else {
                    if (e.removedNodes && 0 < e.removedNodes.length) return !0;
                    if (Array.isArray(e)) return e.some(function (e) {
                        return t._isChangeMutation(e)
                    })
                }
                return !1
            }, o.prototype._syncSubtree = function (e) {
                var e = this._isChangeMutation(e), t = this;
                e && this.dataAdapter.current(function (e) {
                    t.trigger("selection:update", {data: e})
                })
            }, o.prototype.trigger = function (e, t) {
                var n = o.__super__.trigger, s = {
                    open: "opening",
                    close: "closing",
                    select: "selecting",
                    unselect: "unselecting",
                    clear: "clearing"
                };
                if (void 0 === t && (t = {}), e in s) {
                    var i = s[e], s = {prevented: !1, name: e, args: t};
                    if (n.call(this, i, s), s.prevented) return void (t.prevented = !0)
                }
                n.call(this, e, t)
            }, o.prototype.toggleDropdown = function () {
                this.isDisabled() || (this.isOpen() ? this.close() : this.open())
            }, o.prototype.open = function () {
                this.isOpen() || this.isDisabled() || this.trigger("query", {})
            }, o.prototype.close = function (e) {
                this.isOpen() && this.trigger("close", {originalEvent: e})
            }, o.prototype.isEnabled = function () {
                return !this.isDisabled()
            }, o.prototype.isDisabled = function () {
                return this.options.get("disabled")
            }, o.prototype.isOpen = function () {
                return this.$container[0].classList.contains("select2-container--open")
            }, o.prototype.hasFocus = function () {
                return this.$container[0].classList.contains("select2-container--focus")
            }, o.prototype.focus = function (e) {
                this.hasFocus() || (this.$container[0].classList.add("select2-container--focus"), this.trigger("focus", {}))
            }, o.prototype.enable = function (e) {
                this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.');
                e = !(e = null == e || 0 === e.length ? [!0] : e)[0];
                this.$element.prop("disabled", e)
            }, o.prototype.data = function () {
                this.options.get("debug") && 0 < arguments.length && window.console && console.warn && console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');
                var t = [];
                return this.dataAdapter.current(function (e) {
                    t = e
                }), t
            }, o.prototype.val = function (e) {
                if (this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'), null == e || 0 === e.length) return this.$element.val();
                e = e[0];
                Array.isArray(e) && (e = e.map(function (e) {
                    return e.toString()
                })), this.$element.val(e).trigger("input").trigger("change")
            }, o.prototype.destroy = function () {
                r.RemoveData(this.$container[0]), this.$container.remove(), this._observer.disconnect(), this._observer = null, this._syncA = null, this._syncS = null, this.$element.off(".select2"), this.$element.attr("tabindex", r.GetData(this.$element[0], "old-tabindex")), this.$element[0].classList.remove("select2-hidden-accessible"), this.$element.attr("aria-hidden", "false"), r.RemoveData(this.$element[0]), this.$element.removeData("select2"), this.dataAdapter.destroy(), this.selection.destroy(), this.dropdown.destroy(), this.results.destroy(), this.dataAdapter = null, this.selection = null, this.dropdown = null, this.results = null
            }, o.prototype.render = function () {
                var e = t('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');
                return e.attr("dir", this.options.get("dir")), this.$container = e, this.$container[0].classList.add("select2-container--"+this.options.get("theme")), r.StoreData(e[0], "element", this.$element), e
            }, o
        }), u.define("jquery-mousewheel", ["jquery"], function (e) {
            return e
        }), u.define("jquery.select2", ["jquery", "jquery-mousewheel", "./select2/core", "./select2/defaults", "./select2/utils"], function (i, e, r, t, o) {
            var a;
            return null == i.fn.select2 && (a = ["open", "close", "destroy"], i.fn.select2 = function (t) {
                if ("object" == typeof (t = t || {})) return this.each(function () {
                    var e = i.extend(!0, {}, t);
                    new r(i(this), e)
                }), this;
                if ("string" != typeof t) throw new Error("Invalid arguments for Select2: "+t);
                var n, s = Array.prototype.slice.call(arguments, 1);
                return this.each(function () {
                    var e = o.GetData(this, "select2");
                    null == e && window.console && console.error && console.error("The select2('"+t+"') method was called on an element that is not using Select2."), n = e[t].apply(e, s)
                }), -1 < a.indexOf(t) ? this : n
            }), null == i.fn.select2.defaults && (i.fn.select2.defaults = t), r
        }), {define: u.define, require: u.require});

    function b(e, t) {
        return i.call(e, t)
    }

    function l(e, t) {
        var n, s, i, r, o, a, l, c, u, d, p = t && t.split("/"), h = y.map, f = h && h["*"] || {};
        if (e) {
            for (t = (e = e.split("/")).length-1, y.nodeIdCompat && _.test(e[t]) && (e[t] = e[t].replace(_, "")), "." === e[0].charAt(0) && p && (e = p.slice(0, p.length-1).concat(e)), c = 0; c < e.length; c++) "." === (d = e[c]) ? (e.splice(c, 1), --c) : ".." === d && (0 === c || 1 === c && ".." === e[2] || ".." === e[c-1] || 0 < c && (e.splice(c-1, 2), c -= 2));
            e = e.join("/")
        }
        if ((p || f) && h) {
            for (c = (n = e.split("/")).length; 0 < c; --c) {
                if (s = n.slice(0, c).join("/"), p) for (u = p.length; 0 < u; --u) if (i = h[p.slice(0, u).join("/")], i = i && i[s]) {
                    r = i, o = c;
                    break
                }
                if (r) break;
                !a && f && f[s] && (a = f[s], l = c)
            }
            !r && a && (r = a, o = l), r && (n.splice(0, o, r), e = n.join("/"))
        }
        return e
    }

    function w(t, n) {
        return function () {
            var e = a.call(arguments, 0);
            return "string" != typeof e[0] && 1 === e.length && e.push(null), o.apply(p, e.concat([t, n]))
        }
    }

    function x(e) {
        var t;
        if (b(m, e) && (t = m[e], delete m[e], v[e] = !0, r.apply(p, t)), !b(g, e) && !b(v, e)) throw new Error("No "+e);
        return g[e]
    }

    function c(e) {
        var t, n = e ? e.indexOf("!") : -1;
        return -1 < n && (t = e.substring(0, n), e = e.substring(n+1, e.length)), [t, e]
    }

    function A(e) {
        return e ? c(e) : []
    }

    var u = s.require("jquery.select2");
    return t.fn.select2.amd = s, u
});
/*!
 * jQuery Raty - A Star Rating Plugin
 *
 * The MIT License
 *
 * author:  Washington Botelho
 * github:  wbotelhos/raty
 * version: 2.8.0
 *
 */

(function ($) {
    'use strict';

    var methods = {
        init: function (options) {
            return this.each(function () {
                this.self = $(this);

                methods.destroy.call(this.self);

                this.opt = $.extend(true, {}, $.fn.raty.defaults, options, this.self.data());

                methods._adjustCallback.call(this);
                methods._adjustNumber.call(this);
                methods._adjustHints.call(this);

                this.opt.score = methods._adjustedScore.call(this, this.opt.score);

                if (this.opt.starType !== 'img') {
                    methods._adjustStarType.call(this);
                }

                methods._adjustPath.call(this);
                methods._createStars.call(this);

                if (this.opt.cancel) {
                    methods._createCancel.call(this);
                }

                if (this.opt.precision) {
                    methods._adjustPrecision.call(this);
                }

                methods._createScore.call(this);
                methods._apply.call(this, this.opt.score);
                methods._setTitle.call(this, this.opt.score);
                methods._target.call(this, this.opt.score);

                if (this.opt.readOnly) {
                    methods._lock.call(this);
                } else {
                    this.style.cursor = 'pointer';

                    methods._binds.call(this);
                }
            });
        },

        _adjustCallback: function () {
            var options = ['number', 'readOnly', 'score', 'scoreName', 'target', 'path'];

            for (var i = 0; i < options.length; i++) {
                if (typeof this.opt[options[i]] === 'function') {
                    this.opt[options[i]] = this.opt[options[i]].call(this);
                }
            }
        },

        _adjustedScore: function (score) {
            if (!score) {
                return score;
            }

            return methods._between(score, 0, this.opt.number);
        },

        _adjustHints: function () {
            if (!this.opt.hints) {
                this.opt.hints = [];
            }

            if (!this.opt.halfShow && !this.opt.half) {
                return;
            }

            var steps = this.opt.precision ? 10 : 2;

            for (var i = 0; i < this.opt.number; i++) {
                var group = this.opt.hints[i];

                if (Object.prototype.toString.call(group) !== '[object Array]') {
                    group = [group];
                }

                this.opt.hints[i] = [];

                for (var j = 0; j < steps; j++) {
                    var
                        hint = group[j],
                        last = group[group.length-1];

                    if (last === undefined) {
                        last = null;
                    }

                    this.opt.hints[i][j] = hint === undefined ? last : hint;
                }
            }
        },

        _adjustNumber: function () {
            this.opt.number = methods._between(this.opt.number, 1, this.opt.numberMax);
        },

        _adjustPath: function () {
            this.opt.path = this.opt.path || '';

            if (this.opt.path && this.opt.path.charAt(this.opt.path.length-1) !== '/') {
                this.opt.path += '/';
            }
        },

        _adjustPrecision: function () {
            this.opt.half = true;
        },

        _adjustStarType: function () {
            var replaces = ['cancelOff', 'cancelOn', 'starHalf', 'starOff', 'starOn'];

            this.opt.path = '';

            for (var i = 0; i < replaces.length; i++) {
                this.opt[replaces[i]] = this.opt[replaces[i]].replace('.', '-');
            }
        },

        _apply: function (score) {
            methods._fill.call(this, score);

            if (score) {
                if (score > 0) {
                    this.score.val(score);
                }

                methods._roundStars.call(this, score);
            }
        },

        _between: function (value, min, max) {
            return Math.min(Math.max(parseFloat(value), min), max);
        },

        _binds: function () {
            if (this.cancel) {
                methods._bindOverCancel.call(this);
                methods._bindClickCancel.call(this);
                methods._bindOutCancel.call(this);
            }

            methods._bindOver.call(this);
            methods._bindClick.call(this);
            methods._bindOut.call(this);
        },

        _bindClick: function () {
            var that = this;

            that.stars.on('click.raty', function (evt) {
                var
                    execute = true,
                    score = (that.opt.half || that.opt.precision) ? that.self.data('score') : (this.alt || $(this).data('alt'));

                if (that.opt.click) {
                    execute = that.opt.click.call(that, +score, evt);
                }

                if (execute || execute === undefined) {
                    if (that.opt.half && !that.opt.precision) {
                        score = methods._roundHalfScore.call(that, score);
                    }

                    methods._apply.call(that, score);
                }
            });
        },

        _bindClickCancel: function () {
            var that = this;

            that.cancel.on('click.raty', function (evt) {
                that.score.removeAttr('value');

                if (that.opt.click) {
                    that.opt.click.call(that, null, evt);
                }
            });
        },

        _bindOut: function () {
            var that = this;

            that.self.on('mouseleave.raty', function (evt) {
                var score = +that.score.val() || undefined;

                methods._apply.call(that, score);
                methods._target.call(that, score, evt);
                methods._resetTitle.call(that);

                if (that.opt.mouseout) {
                    that.opt.mouseout.call(that, score, evt);
                }
            });
        },

        _bindOutCancel: function () {
            var that = this;

            that.cancel.on('mouseleave.raty', function (evt) {
                var icon = that.opt.cancelOff;

                if (that.opt.starType !== 'img') {
                    icon = that.opt.cancelClass+' '+icon;
                }

                methods._setIcon.call(that, this, icon);

                if (that.opt.mouseout) {
                    var score = +that.score.val() || undefined;

                    that.opt.mouseout.call(that, score, evt);
                }
            });
        },

        _bindOver: function () {
            var
                that = this,
                action = that.opt.half ? 'mousemove.raty' : 'mouseover.raty';

            that.stars.on(action, function (evt) {
                var score = methods._getScoreByPosition.call(that, evt, this);

                methods._fill.call(that, score);

                if (that.opt.half) {
                    methods._roundStars.call(that, score, evt);
                    methods._setTitle.call(that, score, evt);

                    that.self.data('score', score);
                }

                methods._target.call(that, score, evt);

                if (that.opt.mouseover) {
                    that.opt.mouseover.call(that, score, evt);
                }
            });
        },

        _bindOverCancel: function () {
            var that = this;

            that.cancel.on('mouseover.raty', function (evt) {
                var
                    starOff = that.opt.path+that.opt.starOff,
                    icon = that.opt.cancelOn;

                if (that.opt.starType === 'img') {
                    that.stars.attr('src', starOff);
                } else {
                    icon = that.opt.cancelClass+' '+icon;

                    that.stars.attr('class', starOff);
                }

                methods._setIcon.call(that, this, icon);
                methods._target.call(that, null, evt);

                if (that.opt.mouseover) {
                    that.opt.mouseover.call(that, null);
                }
            });
        },

        _buildScoreField: function () {
            return $('<input />', {name: this.opt.scoreName, type: 'hidden'}).appendTo(this);
        },

        _createCancel: function () {
            var
                icon = this.opt.path+this.opt.cancelOff,
                cancel = $('<'+this.opt.starType+' />', {title: this.opt.cancelHint, 'class': this.opt.cancelClass});

            if (this.opt.starType === 'img') {
                cancel.attr({src: icon, alt: 'x'});
            } else {
                // TODO: use $.data
                cancel.attr('data-alt', 'x').addClass(icon);
            }

            if (this.opt.cancelPlace === 'left') {
                this.self.prepend('&#160;').prepend(cancel);
            } else {
                this.self.append('&#160;').append(cancel);
            }

            this.cancel = cancel;
        },

        _createScore: function () {
            var score = $(this.opt.targetScore);

            this.score = score.length ? score : methods._buildScoreField.call(this);
        },

        _createStars: function () {
            for (var i = 1; i <= this.opt.number; i++) {
                var
                    name = methods._nameForIndex.call(this, i),
                    attrs = {alt: i, src: this.opt.path+this.opt[name]};

                if (this.opt.starType !== 'img') {
                    attrs = {'data-alt': i, 'class': attrs.src}; // TODO: use $.data.
                }

                attrs.title = methods._getHint.call(this, i);

                $('<'+this.opt.starType+' />', attrs).appendTo(this);

                if (this.opt.space) {
                    this.self.append(i < this.opt.number ? '&#160;' : '');
                }
            }

            this.stars = this.self.children(this.opt.starType);
        },

        _error: function (message) {
            $(this).text(message);

            $.error(message);
        },

        _fill: function (score) {
            var hash = 0;

            for (var i = 1; i <= this.stars.length; i++) {
                var
                    icon,
                    star = this.stars[i-1],
                    turnOn = methods._turnOn.call(this, i, score);

                if (this.opt.iconRange && this.opt.iconRange.length > hash) {
                    var irange = this.opt.iconRange[hash];

                    icon = methods._getRangeIcon.call(this, irange, turnOn);

                    if (i <= irange.range) {
                        methods._setIcon.call(this, star, icon);
                    }

                    if (i === irange.range) {
                        hash++;
                    }
                } else {
                    icon = this.opt[turnOn ? 'starOn' : 'starOff'];

                    methods._setIcon.call(this, star, icon);
                }
            }
        },

        _getFirstDecimal: function (number) {
            var
                decimal = number.toString().split('.')[1],
                result = 0;

            if (decimal) {
                result = parseInt(decimal.charAt(0), 10);

                if (decimal.slice(1, 5) === '9999') {
                    result++;
                }
            }

            return result;
        },

        _getRangeIcon: function (irange, turnOn) {
            return turnOn ? irange.on || this.opt.starOn : irange.off || this.opt.starOff;
        },

        _getScoreByPosition: function (evt, icon) {
            var score = parseInt(icon.alt || icon.getAttribute('data-alt'), 10);

            if (this.opt.half) {
                var
                    size = methods._getWidth.call(this),
                    percent = parseFloat((evt.pageX-$(icon).offset().left) / size);

                score = score-1+percent;
            }

            return score;
        },

        _getHint: function (score, evt) {
            if (score !== 0 && !score) {
                return this.opt.noRatedMsg;
            }

            var
                decimal = methods._getFirstDecimal.call(this, score),
                integer = Math.ceil(score),
                group = this.opt.hints[(integer || 1)-1],
                hint = group,
                set = !evt || this.move;

            if (this.opt.precision) {
                if (set) {
                    decimal = decimal === 0 ? 9 : decimal-1;
                }

                hint = group[decimal];
            } else if (this.opt.halfShow || this.opt.half) {
                decimal = set && decimal === 0 ? 1 : decimal > 5 ? 1 : 0;

                hint = group[decimal];
            }

            return hint === '' ? '' : hint || score;
        },

        _getWidth: function () {
            var width = this.stars[0].width || parseFloat(this.stars.eq(0).css('font-size'));

            if (!width) {
                methods._error.call(this, 'Could not get the icon width!');
            }

            return width;
        },

        _lock: function () {
            var hint = methods._getHint.call(this, this.score.val());

            this.style.cursor = '';
            this.title = hint;

            this.score.prop('readonly', true);
            this.stars.prop('title', hint);

            if (this.cancel) {
                this.cancel.hide();
            }

            this.self.data('readonly', true);
        },

        _nameForIndex: function (i) {
            return this.opt.score && this.opt.score >= i ? 'starOn' : 'starOff';
        },

        _resetTitle: function () {
            for (var i = 0; i < this.opt.number; i++) {
                this.stars[i].title = methods._getHint.call(this, i+1);
            }
        },

        _roundHalfScore: function (score) {
            var
                integer = parseInt(score, 10),
                decimal = methods._getFirstDecimal.call(this, score);

            if (decimal !== 0) {
                decimal = decimal > 5 ? 1 : 0.5;
            }

            return integer+decimal;
        },

        _roundStars: function (score, evt) {
            var
                decimal = (score % 1).toFixed(2),
                name;

            if (evt || this.move) {
                name = decimal > 0.5 ? 'starOn' : 'starHalf';
            } else if (decimal > this.opt.round.down) { // Up: [x.76 .. x.99]
                name = 'starOn';

                if (this.opt.halfShow && decimal < this.opt.round.up) { // Half: [x.26 .. x.75]
                    name = 'starHalf';
                } else if (decimal < this.opt.round.full) { // Down: [x.00 .. x.5]
                    name = 'starOff';
                }
            }

            if (name) {
                var
                    icon = this.opt[name],
                    star = this.stars[Math.ceil(score)-1];

                methods._setIcon.call(this, star, icon);
            } // Full down: [x.00 .. x.25]
        },

        _setIcon: function (star, icon) {
            star[this.opt.starType === 'img' ? 'src' : 'className'] = this.opt.path+icon;
        },

        _setTarget: function (target, score) {
            if (score) {
                score = this.opt.targetFormat.toString().replace('{score}', score);
            }

            if (target.is(':input')) {
                target.val(score);
            } else {
                target.html(score);
            }
        },

        _setTitle: function (score, evt) {
            if (score) {
                var
                    integer = parseInt(Math.ceil(score), 10),
                    star = this.stars[integer-1];

                star.title = methods._getHint.call(this, score, evt);
            }
        },

        _target: function (score, evt) {
            if (this.opt.target) {
                var target = $(this.opt.target);

                if (!target.length) {
                    methods._error.call(this, 'Target selector invalid or missing!');
                }

                var mouseover = evt && evt.type === 'mouseover';

                if (score === undefined) {
                    score = this.opt.targetText;
                } else if (score === null) {
                    score = mouseover ? this.opt.cancelHint : this.opt.targetText;
                } else {
                    if (this.opt.targetType === 'hint') {
                        score = methods._getHint.call(this, score, evt);
                    } else if (this.opt.precision) {
                        score = parseFloat(score).toFixed(1);
                    }

                    var mousemove = evt && evt.type === 'mousemove';

                    if (!mouseover && !mousemove && !this.opt.targetKeep) {
                        score = this.opt.targetText;
                    }
                }

                methods._setTarget.call(this, target, score);
            }
        },

        _turnOn: function (i, score) {
            return this.opt.single ? (i === score) : (i <= score);
        },

        _unlock: function () {
            this.style.cursor = 'pointer';
            this.removeAttribute('title');

            this.score.removeAttr('readonly');

            this.self.data('readonly', false);

            for (var i = 0; i < this.opt.number; i++) {
                this.stars[i].title = methods._getHint.call(this, i+1);
            }

            if (this.cancel) {
                this.cancel.css('display', '');
            }
        },

        cancel: function (click) {
            return this.each(function () {
                var self = $(this);

                if (self.data('readonly') !== true) {
                    methods[click ? 'click' : 'score'].call(self, null);

                    this.score.removeAttr('value');
                }
            });
        },

        click: function (score) {
            return this.each(function () {
                if ($(this).data('readonly') !== true) {
                    score = methods._adjustedScore.call(this, score);

                    methods._apply.call(this, score);

                    if (this.opt.click) {
                        this.opt.click.call(this, score, $.Event('click'));
                    }

                    methods._target.call(this, score);
                }
            });
        },

        destroy: function () {
            return this.each(function () {
                var
                    self = $(this),
                    raw = self.data('raw');

                if (raw) {
                    self.off('.raty').empty().css({cursor: raw.style.cursor}).removeData('readonly');
                } else {
                    self.data('raw', self.clone()[0]);
                }
            });
        },

        getScore: function () {
            var
                score = [],
                value;

            this.each(function () {
                value = this.score.val();

                score.push(value ? +value : undefined);
            });

            return (score.length > 1) ? score : score[0];
        },

        move: function (score) {
            return this.each(function () {
                var
                    integer = parseInt(score, 10),
                    decimal = methods._getFirstDecimal.call(this, score);

                if (integer >= this.opt.number) {
                    integer = this.opt.number-1;
                    decimal = 10;
                }

                var
                    width = methods._getWidth.call(this),
                    steps = width / 10,
                    star = $(this.stars[integer]),
                    percent = star.offset().left+steps * decimal,
                    evt = $.Event('mousemove', {pageX: percent});

                this.move = true;

                star.trigger(evt);

                this.move = false;
            });
        },

        readOnly: function (readonly) {
            return this.each(function () {
                var self = $(this);

                if (self.data('readonly') !== readonly) {
                    if (readonly) {
                        self.off('.raty').children(this.opt.starType).off('.raty');

                        methods._lock.call(this);
                    } else {
                        methods._binds.call(this);
                        methods._unlock.call(this);
                    }

                    self.data('readonly', readonly);
                }
            });
        },

        reload: function () {
            return methods.set.call(this, {});
        },

        score: function () {
            var self = $(this);

            return arguments.length ? methods.setScore.apply(self, arguments) : methods.getScore.call(self);
        },

        set: function (options) {
            return this.each(function () {
                $(this).raty($.extend({}, this.opt, options));
            });
        },

        setScore: function (score) {
            return this.each(function () {
                if ($(this).data('readonly') !== true) {
                    score = methods._adjustedScore.call(this, score);

                    methods._apply.call(this, score);
                    methods._target.call(this, score);
                }
            });
        }
    };

    $.fn.raty = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method '+method+' does not exist!');
        }
    };

    $.fn.raty.defaults = {
        cancel: false,
        cancelClass: 'raty-cancel',
        cancelHint: 'Cancel this rating!',
        cancelOff: 'cancel-off.png',
        cancelOn: 'cancel-on.png',
        cancelPlace: 'left',
        click: undefined,
        half: false,
        halfShow: true,
        hints: ['bad', 'poor', 'regular', 'good', 'gorgeous'],
        iconRange: undefined,
        mouseout: undefined,
        mouseover: undefined,
        noRatedMsg: 'Not rated yet!',
        number: 5,
        numberMax: 20,
        path: undefined,
        precision: false,
        readOnly: false,
        round: {down: 0.25, full: 0.6, up: 0.76},
        score: undefined,
        scoreName: 'score',
        single: false,
        space: true,
        starHalf: 'star-half.png',
        starOff: 'star-off.png',
        starOn: 'star-on.png',
        starType: 'img',
        target: undefined,
        targetFormat: '{score}',
        targetKeep: false,
        targetScore: undefined,
        targetText: '',
        targetType: 'hint'
    };
})(jQuery);

/*
 currency.js - v2.0.4
 http://scurker.github.io/currency.js

 Copyright (c) 2021 Jason Wilson
 Released under MIT license
*/
(function (e, g) {
    "object" === typeof exports && "undefined" !== typeof module ? module.exports = g() : "function" === typeof define && define.amd ? define(g) : (e = e || self, e.currency = g())
})(this, function () {
    function e(b, a) {
        if (!(this instanceof e)) return new e(b, a);
        a = Object.assign({}, m, a);
        var d = Math.pow(10, a.precision);
        this.intValue = b = g(b, a);
        this.value = b / d;
        a.increment = a.increment || 1 / d;
        a.groups = a.useVedic ? n : p;
        this.s = a;
        this.p = d
    }

    function g(b, a) {
        var d = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : !0;
        var c = a.decimal;
        var h = a.errorOnInvalid, k = a.fromCents, l = Math.pow(10, a.precision), f = b instanceof e;
        if (f && k) return b.intValue;
        if ("number" === typeof b || f) c = f ? b.value : b; else if ("string" === typeof b) h = new RegExp("[^-\\d"+c+"]", "g"), c = new RegExp("\\"+c, "g"), c = (c = b.replace(/\((.*)\)/, "-$1").replace(h, "").replace(c, ".")) || 0; else {
            if (h) throw Error("Invalid Input");
            c = 0
        }
        k || (c = (c * l).toFixed(4));
        return d ? Math.round(c) : c
    }

    var m = {
        symbol: "$",
        separator: ",",
        decimal: ".",
        errorOnInvalid: !1,
        precision: 2,
        pattern: "!#",
        negativePattern: "-!#",
        format: function (b,
                          a) {
            var d = a.pattern, c = a.negativePattern, h = a.symbol, k = a.separator, l = a.decimal;
            a = a.groups;
            var f = (""+b).replace(/^-/, "").split("."), q = f[0];
            f = f[1];
            return (0 <= b.value ? d : c).replace("!", h).replace("#", q.replace(a, "$1"+k)+(f ? l+f : ""))
        },
        fromCents: !1
    }, p = /(\d)(?=(\d{3})+\b)/g, n = /(\d)(?=(\d\d)+\d\b)/g;
    e.prototype = {
        add: function (b) {
            var a = this.s, d = this.p;
            return e((this.intValue+g(b, a)) / (a.fromCents ? 1 : d), a)
        }, subtract: function (b) {
            var a = this.s, d = this.p;
            return e((this.intValue-g(b, a)) / (a.fromCents ? 1 : d), a)
        }, multiply: function (b) {
            var a =
                this.s;
            return e(this.intValue * b / (a.fromCents ? 1 : Math.pow(10, a.precision)), a)
        }, divide: function (b) {
            var a = this.s;
            return e(this.intValue / g(b, a, !1), a)
        }, distribute: function (b) {
            var a = this.intValue, d = this.p, c = this.s, h = [], k = Math[0 <= a ? "floor" : "ceil"](a / b),
                l = Math.abs(a-k * b);
            for (d = c.fromCents ? 1 : d; 0 !== b; b--) {
                var f = e(k / d, c);
                0 < l-- && (f = f[0 <= a ? "add" : "subtract"](1 / d));
                h.push(f)
            }
            return h
        }, dollars: function () {
            return ~~this.value
        }, cents: function () {
            return ~~(this.intValue % this.p)
        }, format: function (b) {
            var a = this.s;
            return "function" ===
            typeof b ? b(this, a) : a.format(this, Object.assign({}, a, b))
        }, toString: function () {
            var b = this.s, a = b.increment;
            return (Math.round(this.intValue / this.p / a) * a).toFixed(b.precision)
        }, toJSON: function () {
            return this.value
        }
    };
    return e
});

$.fn.tabs = function () {
    var selector = this

    this.each(function () {
        var obj = $(this)

        $(obj.attr('rel')).hide()

        $(obj).click(function () {
            $(selector).removeClass('active')

            $(selector).each(function (i, element) {
                $($(element).attr('rel')).hide()
            })

            $(this).addClass('active')

            $($(this).attr('rel')).show()

            return false
        })
    })

    $(this).show()

    $(this).first().click()
}

/*
 * Ensure the CSRF token is added to all AJAX requests.
 */
$.ajaxPrefilter(function (options) {
    var token = $('meta[name="csrf-token"]').attr('content')

    if (token) {
        if (!options.headers) options.headers = {}
        options.headers['X-CSRF-TOKEN'] = token
    }
})

$(function () {
    $(window).on('ajaxErrorMessage', function (event, message) {
        event.preventDefault()
        $.ti.flashMessage({class: 'danger', text: message})
    })
})

$(function () {
    var $el = $('[data-control="cookie-banner"]'),
        $btn = $el.find('#eu-cookie-action'),
        options = $.extend({}, $el.data()),
        cookieName = 'complianceCookie',
        cookieValue = 'on',
        cookieDuration = 30

    if ($el.length) {
        if (options.active === 1) {
            if (checkCookie(cookieName) !== cookieValue) {
                $el.fadeIn()
            }
        } else {
            eraseCookie('complianceCookie');
        }
    }

    $btn.on('click', function (event) {
        createCookie(cookieName, cookieValue, cookieDuration);
        $el.fadeOut()
    })

    function createCookie(name, value, days) {
        var expires = ''

        if (days) {
            var date = new Date()
            date.setTime(date.getTime()+(days * 24 * 60 * 60 * 1000))
            expires = '; expires='+date.toGMTString()
        }

        document.cookie = name+"="+value+expires+"; path=/"
    }

    function checkCookie(name) {
        var nameEQ = name+"=",
            ca = document.cookie.split(';')

        for (var i = 0; i < ca.length; i++) {
            var c = ca[i]
            while (c.charAt(0) === ' ') c = c.substring(1, c.length)
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length)
        }

        return null
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }
})

// CURRENCY HELPER FUNCTION DEFINITION
// ============================
$(function () {
    if (app) {
        app.currencyFormat = function (amount) {
            if (!app.currency)
                throw 'Currency values not defined in app scope';

            return currency(amount, {
                decimal: app.currency.decimal_sign,
                precision: app.currency.decimal_precision,
                separator: app.currency.thousand_sign,
                symbol: app.currency.symbol,
                pattern: app.currency.symbol_position ? '#!' : '!#',
            }).format();

        };
    }
})


