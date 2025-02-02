(function(b) {
    var e,d,a = [],c = window;
    b.fn.tinymce = function(j) {
        var p = this,g,k,h,m,i,l = "",n = "";
        if (!p.length) {
            return p
        }
        if (!j) {
            return tinyMCE.get(p[0].id)
        }
        p.css("visibility", "hidden");
        function o() {
            var r = [],q = 0;
            if (f) {
                f();
                f = null
            }
            p.each(function(t, u) {
                var s,w = u.id,v = j.oninit;
                if (!w) {
                    u.id = w = tinymce.DOM.uniqueId()
                }
                s = new tinymce.Editor(w, j);
                r.push(s);
                s.onInit.add(function() {
                    var x,y = v;
                    p.css("visibility", "");
                    if (v) {
                        if (++q == r.length) {
                            if (tinymce.is(y, "string")) {
                                x = (y.indexOf(".") === -1) ? null : tinymce.resolve(y.replace(/\.\w+$/, ""));
                                y = tinymce.resolve(y)
                            }
                            y.apply(x || tinymce, r)
                        }
                    }
                })
            });
            b.each(r, function(t, s) {
                s.render()
            })
        }

        if (!c.tinymce && !d && (g = j.script_url)) {
            d = 1;
            h = g.substring(0, g.lastIndexOf("/"));
            if (/_(src|dev)\.js/g.test(g)) {
                n = "_src"
            }
            m = g.lastIndexOf("?");
            if (m != -1) {
                l = g.substring(m + 1)
            }
            c.tinyMCEPreInit = c.tinyMCEPreInit || {base:h,suffix:n,query:l};
            if (g.indexOf("gzip") != -1) {
                i = j.language || "en";
                g = g + (/\?/.test(g) ? "&" : "?") + "js=true&core=true&suffix=" + escape(n) + "&themes=" + escape(j.theme) + "&plugins=" + escape(j.plugins) + "&languages=" + i;
                if (!c.tinyMCE_GZ) {
                    tinyMCE_GZ = {start:function() {
                        tinymce.suffix = n;
                        function q(r) {
                            tinymce.ScriptLoader.markDone(tinyMCE.baseURI.toAbsolute(r))
                        }

                        q("langs/" + i + ".js");
                        q("themes/" + j.theme + "/editor_template" + n + ".js");
                        q("themes/" + j.theme + "/langs/" + i + ".js");
                        b.each(j.plugins.split(","), function(s, r) {
                            if (r) {
                                q("plugins/" + r + "/editor_plugin" + n + ".js");
                                q("plugins/" + r + "/langs/" + i + ".js")
                            }
                        })
                    },end:function() {
                    }}
                }
            }
            b.ajax({type:"GET",url:g,dataType:"script",cache:true,success:function() {
                tinymce.dom.Event.domLoaded = 1;
                d = 2;
                if (j.script_loaded) {
                    j.script_loaded()
                }
                o();
                b.each(a, function(q, r) {
                    r()
                })
            }})
        } else {
            if (d === 1) {
                a.push(o)
            } else {
                o()
            }
        }
        return p
    };
    b.extend(b.expr[":"], {tinymce:function(g) {
        return g.id && !!tinyMCE.get(g.id)
    }});
    function f() {
        function i(l) {
            if (l === "remove") {
                this.each(function(n, o) {
                    var m = h(o);
                    if (m) {
                        m.remove()
                    }
                })
            }
            this.find("span.mceEditor,div.mceEditor").each(function(n, o) {
                var m = tinyMCE.get(o.id.replace(/_parent$/, ""));
                if (m) {
                    m.remove()
                }
            })
        }

        function k(n) {
            var m = this,l;
            if (n !== e) {
                i.call(m);
                m.each(function(p, q) {
                    var o;
                    if (o = tinyMCE.get(q.id)) {
                        o.setContent(n)
                    }
                })
            } else {
                if (m.length > 0) {
                    if (l = tinyMCE.get(m[0].id)) {
                        return l.getContent()
                    }
                }
            }
        }

        function h(m) {
            var l = null;
            (m) && (m.id) && (c.tinymce) && (l = tinyMCE.get(m.id));
            return l
        }

        function g(l) {
            return !!((l) && (l.length) && (c.tinymce) && (l.is(":tinymce")))
        }

        var j = {};
        b.each(["text","html","val"], function(n, l) {
            var o = j[l] = b.fn[l],m = (l === "text");
            b.fn[l] = function(s) {
                var p = this;
                if (!g(p)) {
                    return o.apply(p, arguments)
                }
                if (s !== e) {
                    k.call(p.filter(":tinymce"), s);
                    o.apply(p.not(":tinymce"), arguments);
                    return p
                } else {
                    var r = "";
                    var q = arguments;
                    (m ? p : p.eq(0)).each(function(u, v) {
                        var t = h(v);
                        r += t ? (m ? t.getContent().replace(/<(?:"[^"]*"|'[^']*'|[^'">])*>/g, "") : t.getContent()) : o.apply(b(v), q)
                    });
                    return r
                }
            }
        });
        b.each(["append","prepend"], function(n, m) {
            var o = j[m] = b.fn[m],l = (m === "prepend");
            b.fn[m] = function(q) {
                var p = this;
                if (!g(p)) {
                    return o.apply(p, arguments)
                }
                if (q !== e) {
                    p.filter(":tinymce").each(function(s, t) {
                        var r = h(t);
                        r && r.setContent(l ? q + r.getContent() : r.getContent() + q)
                    });
                    o.apply(p.not(":tinymce"), arguments);
                    return p
                }
            }
        });
        b.each(["remove","replaceWith","replaceAll","empty"], function(m, l) {
            var n = j[l] = b.fn[l];
            b.fn[l] = function() {
                i.call(this, l);
                return n.apply(this, arguments)
            }
        });
        j.attr = b.fn.attr;
        b.fn.attr = function(n, q, o) {
            var m = this;
            if ((!n) || (n !== "value") || (!g(m))) {
                return j.attr.call(m, n, q, o)
            }
            if (q !== e) {
                k.call(m.filter(":tinymce"), q);
                j.attr.call(m.not(":tinymce"), n, q, o);
                return m
            } else {
                var p = m[0],l = h(p);
                return l ? l.getContent() : j.attr.call(b(p), n, q, o)
            }
        }
    }
})(jQuery);