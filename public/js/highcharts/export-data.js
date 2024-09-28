!(
    /**
     * Highcharts JS v11.4.8 (2024-08-29)
     *
     * Exporting module
     *
     * (c) 2010-2024 Torstein Honsi
     *
     * License: www.highcharts.com/license

     */ (function (t) {
        "object" == typeof module && module.exports
            ? ((t.default = t), (module.exports = t))
            : "function" == typeof define && define.amd
              ? define(
                    "highcharts/modules/export-data",
                    ["highcharts", "highcharts/modules/exporting"],
                    function (e) {
                        return t(e), (t.Highcharts = e), t;
                    },
                )
              : t("undefined" != typeof Highcharts ? Highcharts : void 0);
    })(function (t) {
        "use strict";
        var e = t ? t._modules : {};
        function o(e, o, a, n) {
            e.hasOwnProperty(o) ||
                ((e[o] = n.apply(null, a)),
                "function" == typeof CustomEvent &&
                    t.win.dispatchEvent(
                        new CustomEvent("HighchartsModuleLoaded", {
                            detail: { path: o, module: e[o] },
                        }),
                    ));
        }
        o(e, "Extensions/DownloadURL.js", [e["Core/Globals.js"]], function (t) {
            let {
                    isSafari: e,
                    win: o,
                    win: { document: a },
                } = t,
                n = o.URL || o.webkitURL || o;
            function i(t) {
                let e = t
                    .replace(/filename=.*;/, "")
                    .match(/data:([^;]*)(;base64)?,([A-Z+\d\/]+)/i);
                if (
                    e &&
                    e.length > 3 &&
                    o.atob &&
                    o.ArrayBuffer &&
                    o.Uint8Array &&
                    o.Blob &&
                    n.createObjectURL
                ) {
                    let t = o.atob(e[3]),
                        a = new o.ArrayBuffer(t.length),
                        i = new o.Uint8Array(a);
                    for (let e = 0; e < i.length; ++e) i[e] = t.charCodeAt(e);
                    return n.createObjectURL(new o.Blob([i], { type: e[1] }));
                }
            }
            return {
                dataURLtoBlob: i,
                downloadURL: function (t, n) {
                    let r = o.navigator,
                        s = a.createElement("a");
                    if (
                        "string" != typeof t &&
                        !(t instanceof String) &&
                        r.msSaveOrOpenBlob
                    ) {
                        r.msSaveOrOpenBlob(t, n);
                        return;
                    }
                    if (((t = "" + t), r.userAgent.length > 1e3))
                        throw Error("Input too long");
                    let l = /Edge\/\d+/.test(r.userAgent);
                    if (
                        ((e &&
                            "string" == typeof t &&
                            0 === t.indexOf("data:application/pdf")) ||
                            l ||
                            t.length > 2e6) &&
                        !(t = i(t) || "")
                    )
                        throw Error("Failed to convert to blob");
                    if (void 0 !== s.download)
                        (s.href = t),
                            (s.download = n),
                            a.body.appendChild(s),
                            s.click(),
                            a.body.removeChild(s);
                    else
                        try {
                            if (!o.open(t, "chart"))
                                throw Error("Failed to open window");
                        } catch {
                            o.location.href = t;
                        }
                },
            };
        }),
            o(
                e,
                "Extensions/ExportData/ExportDataDefaults.js",
                [],
                function () {
                    return {
                        exporting: {
                            csv: {
                                annotations: { itemDelimiter: "; ", join: !1 },
                                columnHeaderFormatter: null,
                                dateFormat: "%Y-%m-%d %H:%M:%S",
                                decimalPoint: null,
                                itemDelimiter: null,
                                lineDelimiter: "\n",
                            },
                            showTable: !1,
                            useMultiLevelHeaders: !0,
                            useRowspanHeaders: !0,
                            showExportInProgress: !0,
                        },
                        lang: {
                            downloadCSV: "Download CSV",
                            downloadXLS: "Download XLS",
                            exportData: {
                                annotationHeader: "Annotations",
                                categoryHeader: "Category",
                                categoryDatetimeHeader: "DateTime",
                            },
                            viewData: "View data table",
                            hideData: "Hide data table",
                            exportInProgress: "Exporting...",
                        },
                    };
                },
            ),
            o(
                e,
                "Extensions/ExportData/ExportData.js",
                [
                    e["Core/Renderer/HTML/AST.js"],
                    e["Core/Defaults.js"],
                    e["Extensions/DownloadURL.js"],
                    e["Extensions/ExportData/ExportDataDefaults.js"],
                    e["Core/Globals.js"],
                    e["Core/Utilities.js"],
                ],
                function (t, e, o, a, n, i) {
                    let { getOptions: r, setOptions: s } = e,
                        { downloadURL: l } = o,
                        { doc: h, win: c } = n,
                        {
                            addEvent: d,
                            defined: p,
                            extend: u,
                            find: m,
                            fireEvent: g,
                            isNumber: x,
                            pick: f,
                        } = i;
                    function b(t) {
                        let e = !!this.options.exporting?.showExportInProgress,
                            o = c.requestAnimationFrame || setTimeout;
                        o(() => {
                            e &&
                                this.showLoading(
                                    this.options.lang.exportInProgress,
                                ),
                                o(() => {
                                    try {
                                        t.call(this);
                                    } finally {
                                        e && this.hideLoading();
                                    }
                                });
                        });
                    }
                    function y() {
                        b.call(this, () => {
                            let t = this.getCSV(!0);
                            l(
                                A(t, "text/csv") ||
                                    "data:text/csv,\uFEFF" +
                                        encodeURIComponent(t),
                                this.getFilename() + ".csv",
                            );
                        });
                    }
                    function w() {
                        b.call(this, () => {
                            let t =
                                '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Ark1</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><style>td{border:none;font-family: Calibri, sans-serif;} .number{mso-number-format:"0.00";} .text{ mso-number-format:"@";}</style><meta name=ProgId content=Excel.Sheet><meta charset=UTF-8></head><body>' +
                                this.getTable(!0) +
                                "</body></html>";
                            l(
                                A(t, "application/vnd.ms-excel") ||
                                    "data:application/vnd.ms-excel;base64," +
                                        c.btoa(unescape(encodeURIComponent(t))),
                                this.getFilename() + ".xls",
                            );
                        });
                    }
                    function D(t) {
                        let e = "",
                            o = this.getDataRows(),
                            a = this.options.exporting.csv,
                            n = f(
                                a.decimalPoint,
                                "," !== a.itemDelimiter && t
                                    ? (1.1).toLocaleString()[1]
                                    : ".",
                            ),
                            i = f(a.itemDelimiter, "," === n ? ";" : ","),
                            r = a.lineDelimiter;
                        return (
                            o.forEach((t, a) => {
                                let s = "",
                                    l = t.length;
                                for (; l--; )
                                    "string" == typeof (s = t[l]) &&
                                        (s = `"${s}"`),
                                        "number" == typeof s &&
                                            "." !== n &&
                                            (s = s.toString().replace(".", n)),
                                        (t[l] = s);
                                (t.length = o.length ? o[0].length : 0),
                                    (e += t.join(i)),
                                    a < o.length - 1 && (e += r);
                            }),
                            e
                        );
                    }
                    function T(t) {
                        let e, o;
                        let a = this.hasParallelCoordinates,
                            n = this.time,
                            i =
                                (this.options.exporting &&
                                    this.options.exporting.csv) ||
                                {},
                            r = this.xAxis,
                            s = {},
                            l = [],
                            h = [],
                            c = [],
                            d = this.options.lang.exportData,
                            u = d.categoryHeader,
                            b = d.categoryDatetimeHeader,
                            y = function (e, o, a) {
                                if (i.columnHeaderFormatter) {
                                    let t = i.columnHeaderFormatter(e, o, a);
                                    if (!1 !== t) return t;
                                }
                                return e
                                    ? e.bindAxes
                                        ? t
                                            ? {
                                                  columnTitle:
                                                      a > 1 ? o : e.name,
                                                  topLevelColumnTitle: e.name,
                                              }
                                            : e.name +
                                              (a > 1 ? " (" + o + ")" : "")
                                        : (e.options.title &&
                                              e.options.title.text) ||
                                          (e.dateTime ? b : u)
                                    : u;
                            },
                            w = function (t, e, o) {
                                let a = {},
                                    n = {};
                                return (
                                    e.forEach(function (e) {
                                        let i =
                                                ((t.keyToAxis &&
                                                    t.keyToAxis[e]) ||
                                                    e) + "Axis",
                                            r = x(o) ? t.chart[i][o] : t[i];
                                        (a[e] = (r && r.categories) || []),
                                            (n[e] = r && r.dateTime);
                                    }),
                                    { categoryMap: a, dateTimeValueAxisMap: n }
                                );
                            },
                            D = function (t, e) {
                                let o = t.pointArrayMap || ["y"];
                                return t.data.some(
                                    (t) => void 0 !== t.y && t.name,
                                ) &&
                                    e &&
                                    !e.categories &&
                                    "name" !== t.exportKey
                                    ? ["x", ...o]
                                    : o;
                            },
                            T = [],
                            v,
                            E,
                            L,
                            S = 0,
                            C,
                            A;
                        for (C in (this.series.forEach(function (e) {
                            let o = e.options.keys,
                                l = e.xAxis,
                                d = o || D(e, l),
                                p = d.length,
                                u = !e.requireSorting && {},
                                g = r.indexOf(l),
                                x = w(e, d),
                                b,
                                v;
                            if (
                                !1 !== e.options.includeInDataExport &&
                                !e.options.isInternal &&
                                !1 !== e.visible
                            ) {
                                for (
                                    m(T, function (t) {
                                        return t[0] === g;
                                    }) || T.push([g, S]),
                                        v = 0;
                                    v < p;

                                )
                                    (L = y(e, d[v], d.length)),
                                        c.push(L.columnTitle || L),
                                        t && h.push(L.topLevelColumnTitle || L),
                                        v++;
                                (b = {
                                    chart: e.chart,
                                    autoIncrement: e.autoIncrement,
                                    options: e.options,
                                    pointArrayMap: e.pointArrayMap,
                                    index: e.index,
                                }),
                                    e.options.data.forEach(function (t, o) {
                                        let r, h, c;
                                        let m = { series: b };
                                        a && (x = w(e, d, o)),
                                            e.pointClass.prototype.applyOptions.apply(
                                                m,
                                                [t],
                                            );
                                        let y = e.data[o] && e.data[o].name;
                                        if (
                                            ((r = (m.x ?? "") + "," + y),
                                            (v = 0),
                                            (!l ||
                                                "name" === e.exportKey ||
                                                (!a && l && l.hasNames && y)) &&
                                                (r = y),
                                            u &&
                                                (u[r] && (r += "|" + o),
                                                (u[r] = !0)),
                                            s[r])
                                        ) {
                                            let t = `${r},${s[r].pointers[e.index]}`,
                                                o = r;
                                            s[r].pointers[e.index] &&
                                                (s[t] ||
                                                    ((s[t] = []),
                                                    (s[t].xValues = []),
                                                    (s[t].pointers = [])),
                                                (r = t)),
                                                (s[o].pointers[e.index] += 1);
                                        } else {
                                            (s[r] = []), (s[r].xValues = []);
                                            let t = [];
                                            for (
                                                let o = 0;
                                                o < e.chart.series.length;
                                                o++
                                            )
                                                t[o] = 0;
                                            (s[r].pointers = t),
                                                (s[r].pointers[e.index] = 1);
                                        }
                                        for (
                                            s[r].x = m.x,
                                                s[r].name = y,
                                                s[r].xValues[g] = m.x;
                                            v < p;

                                        )
                                            (c = m[(h = d[v])]),
                                                (s[r][S + v] = f(
                                                    x.categoryMap[h][c],
                                                    x.dateTimeValueAxisMap[h]
                                                        ? n.dateFormat(
                                                              i.dateFormat,
                                                              c,
                                                          )
                                                        : null,
                                                    c,
                                                )),
                                                v++;
                                    }),
                                    (S += v);
                            }
                        }),
                        s))
                            Object.hasOwnProperty.call(s, C) && l.push(s[C]);
                        for (E = t ? [h, c] : [c], S = T.length; S--; )
                            (e = T[S][0]),
                                (o = T[S][1]),
                                (v = r[e]),
                                l.sort(function (t, o) {
                                    return t.xValues[e] - o.xValues[e];
                                }),
                                (A = y(v)),
                                E[0].splice(o, 0, A),
                                t && E[1] && E[1].splice(o, 0, A),
                                l.forEach(function (t) {
                                    let e = t.name;
                                    v &&
                                        !p(e) &&
                                        (v.dateTime
                                            ? (t.x instanceof Date &&
                                                  (t.x = t.x.getTime()),
                                              (e = n.dateFormat(
                                                  i.dateFormat,
                                                  t.x,
                                              )))
                                            : (e = v.categories
                                                  ? f(
                                                        v.names[t.x],
                                                        v.categories[t.x],
                                                        t.x,
                                                    )
                                                  : t.x)),
                                        t.splice(o, 0, e);
                                });
                        return (
                            g(this, "exportData", {
                                dataRows: (E = E.concat(l)),
                            }),
                            E
                        );
                    }
                    function v(t) {
                        let e = (t) => {
                            if (!t.tagName || "#text" === t.tagName)
                                return t.textContent || "";
                            let o = t.attributes,
                                a = `<${t.tagName}`;
                            return (
                                o &&
                                    Object.keys(o).forEach((t) => {
                                        let e = o[t];
                                        a += ` ${t}="${e}"`;
                                    }),
                                (a += ">" + (t.textContent || "")),
                                (t.children || []).forEach((t) => {
                                    a += e(t);
                                }),
                                (a += `</${t.tagName}>`)
                            );
                        };
                        return e(this.getTableAST(t));
                    }
                    function E(t) {
                        let e = 0,
                            o = [],
                            a = this.options,
                            n = t ? (1.1).toLocaleString()[1] : ".",
                            i = f(a.exporting.useMultiLevelHeaders, !0),
                            r = this.getDataRows(i),
                            s = i ? r.shift() : null,
                            l = r.shift(),
                            h = function (t, e) {
                                let o = t.length;
                                if (e.length !== o) return !1;
                                for (; o--; ) if (t[o] !== e[o]) return !1;
                                return !0;
                            },
                            c = function (t, e, o, a) {
                                let i = f(a, ""),
                                    r = "highcharts-text" + (e ? " " + e : "");
                                return (
                                    "number" == typeof i
                                        ? ((i = i.toString()),
                                          "," === n && (i = i.replace(".", n)),
                                          (r = "highcharts-number"))
                                        : a || (r = "highcharts-empty"),
                                    {
                                        tagName: t,
                                        attributes: (o = u({ class: r }, o)),
                                        textContent: i,
                                    }
                                );
                            };
                        !1 !== a.exporting.tableCaption &&
                            o.push({
                                tagName: "caption",
                                attributes: {
                                    class: "highcharts-table-caption",
                                },
                                textContent: f(
                                    a.exporting.tableCaption,
                                    a.title.text ? a.title.text : "Chart",
                                ),
                            });
                        for (let t = 0, o = r.length; t < o; ++t)
                            r[t].length > e && (e = r[t].length);
                        o.push(
                            (function (t, e, o) {
                                let n = [],
                                    r = 0,
                                    s = o || (e && e.length),
                                    l,
                                    d = 0,
                                    p;
                                if (i && t && e && !h(t, e)) {
                                    let o = [];
                                    for (; r < s; ++r)
                                        if ((l = t[r]) === t[r + 1]) ++d;
                                        else if (d)
                                            o.push(
                                                c(
                                                    "th",
                                                    "highcharts-table-topheading",
                                                    {
                                                        scope: "col",
                                                        colspan: d + 1,
                                                    },
                                                    l,
                                                ),
                                            ),
                                                (d = 0);
                                        else {
                                            l === e[r]
                                                ? a.exporting.useRowspanHeaders
                                                    ? ((p = 2), delete e[r])
                                                    : ((p = 1), (e[r] = ""))
                                                : (p = 1);
                                            let t = c(
                                                "th",
                                                "highcharts-table-topheading",
                                                { scope: "col" },
                                                l,
                                            );
                                            p > 1 &&
                                                t.attributes &&
                                                ((t.attributes.valign = "top"),
                                                (t.attributes.rowspan = p)),
                                                o.push(t);
                                        }
                                    n.push({ tagName: "tr", children: o });
                                }
                                if (e) {
                                    let t = [];
                                    for (r = 0, s = e.length; r < s; ++r)
                                        void 0 !== e[r] &&
                                            t.push(
                                                c(
                                                    "th",
                                                    null,
                                                    { scope: "col" },
                                                    e[r],
                                                ),
                                            );
                                    n.push({ tagName: "tr", children: t });
                                }
                                return { tagName: "thead", children: n };
                            })(s, l, Math.max(e, l.length)),
                        );
                        let d = [];
                        r.forEach(function (t) {
                            let o = [];
                            for (let a = 0; a < e; a++)
                                o.push(
                                    c(
                                        a ? "td" : "th",
                                        null,
                                        a ? {} : { scope: "row" },
                                        t[a],
                                    ),
                                );
                            d.push({ tagName: "tr", children: o });
                        }),
                            o.push({ tagName: "tbody", children: d });
                        let p = {
                            tree: {
                                tagName: "table",
                                id: `highcharts-data-table-${this.index}`,
                                children: o,
                            },
                        };
                        return g(this, "aftergetTableAST", p), p.tree;
                    }
                    function L() {
                        this.toggleDataTable(!1);
                    }
                    function S(e) {
                        let o =
                            (e = f(e, !this.isDataTableVisible)) &&
                            !this.dataTableDiv;
                        if (
                            (o &&
                                ((this.dataTableDiv = h.createElement("div")),
                                (this.dataTableDiv.className =
                                    "highcharts-data-table"),
                                this.renderTo.parentNode.insertBefore(
                                    this.dataTableDiv,
                                    this.renderTo.nextSibling,
                                )),
                            this.dataTableDiv)
                        ) {
                            let a = this.dataTableDiv.style,
                                n = a.display;
                            (a.display = e ? "block" : "none"),
                                e
                                    ? ((this.dataTableDiv.innerHTML =
                                          t.emptyHTML),
                                      new t([this.getTableAST()]).addToDOM(
                                          this.dataTableDiv,
                                      ),
                                      g(this, "afterViewData", {
                                          element: this.dataTableDiv,
                                          wasHidden: o || n !== a.display,
                                      }))
                                    : g(this, "afterHideData");
                        }
                        this.isDataTableVisible = e;
                        let a = this.exportDivElements,
                            n = this.options.exporting,
                            i =
                                n &&
                                n.buttons &&
                                n.buttons.contextButton.menuItems,
                            r = this.options.lang;
                        if (
                            n &&
                            n.menuItemDefinitions &&
                            r &&
                            r.viewData &&
                            r.hideData &&
                            i &&
                            a
                        ) {
                            let e = a[i.indexOf("viewData")];
                            e &&
                                t.setElementHTML(
                                    e,
                                    this.isDataTableVisible
                                        ? r.hideData
                                        : r.viewData,
                                );
                        }
                    }
                    function C() {
                        this.toggleDataTable(!0);
                    }
                    function A(t, e) {
                        let o = c.navigator,
                            a = c.URL || c.webkitURL || c;
                        try {
                            if (o.msSaveOrOpenBlob && c.MSBlobBuilder) {
                                let e = new c.MSBlobBuilder();
                                return e.append(t), e.getBlob("image/svg+xml");
                            }
                            return a.createObjectURL(
                                new c.Blob(["\uFEFF" + t], { type: e }),
                            );
                        } catch (t) {}
                    }
                    function R() {
                        let t = this,
                            e = t.dataTableDiv,
                            o = (t, e) => t.children[e].textContent,
                            a = (t, e) => (a, n) => {
                                let i, r;
                                return (
                                    (i = o(e ? a : n, t)),
                                    (r = o(e ? n : a, t)),
                                    "" === i || "" === r || isNaN(i) || isNaN(r)
                                        ? i.toString().localeCompare(r)
                                        : i - r
                                );
                            };
                        if (
                            e &&
                            t.options.exporting &&
                            t.options.exporting.allowTableSorting
                        ) {
                            let o = e.querySelector("thead tr");
                            o &&
                                o.childNodes.forEach((o) => {
                                    let n = o.closest("table");
                                    o.addEventListener("click", function () {
                                        let i = [
                                                ...e.querySelectorAll(
                                                    "tr:not(thead tr)",
                                                ),
                                            ],
                                            r = [...o.parentNode.children];
                                        i
                                            .sort(
                                                a(
                                                    r.indexOf(o),
                                                    (t.ascendingOrderInTable =
                                                        !t.ascendingOrderInTable),
                                                ),
                                            )
                                            .forEach((t) => {
                                                n.appendChild(t);
                                            }),
                                            r.forEach((t) => {
                                                [
                                                    "highcharts-sort-ascending",
                                                    "highcharts-sort-descending",
                                                ].forEach((e) => {
                                                    t.classList.contains(e) &&
                                                        t.classList.remove(e);
                                                });
                                            }),
                                            o.classList.add(
                                                t.ascendingOrderInTable
                                                    ? "highcharts-sort-ascending"
                                                    : "highcharts-sort-descending",
                                            );
                                    });
                                });
                        }
                    }
                    function k() {
                        this.options &&
                            this.options.exporting &&
                            this.options.exporting.showTable &&
                            !this.options.chart.forExport &&
                            this.viewData();
                    }
                    function H() {
                        this.dataTableDiv?.remove();
                    }
                    return {
                        compose: function (t, e) {
                            let o = t.prototype;
                            if (!o.getCSV) {
                                let n = r().exporting;
                                d(t, "afterViewData", R),
                                    d(t, "render", k),
                                    d(t, "destroy", H),
                                    (o.downloadCSV = y),
                                    (o.downloadXLS = w),
                                    (o.getCSV = D),
                                    (o.getDataRows = T),
                                    (o.getTable = v),
                                    (o.getTableAST = E),
                                    (o.hideData = L),
                                    (o.toggleDataTable = S),
                                    (o.viewData = C),
                                    n &&
                                        (u(n.menuItemDefinitions, {
                                            downloadCSV: {
                                                textKey: "downloadCSV",
                                                onclick: function () {
                                                    this.downloadCSV();
                                                },
                                            },
                                            downloadXLS: {
                                                textKey: "downloadXLS",
                                                onclick: function () {
                                                    this.downloadXLS();
                                                },
                                            },
                                            viewData: {
                                                textKey: "viewData",
                                                onclick: function () {
                                                    b.call(
                                                        this,
                                                        this.toggleDataTable,
                                                    );
                                                },
                                            },
                                        }),
                                        n.buttons &&
                                            n.buttons.contextButton.menuItems &&
                                            n.buttons.contextButton.menuItems.push(
                                                "separator",
                                                "downloadCSV",
                                                "downloadXLS",
                                                "viewData",
                                            )),
                                    s(a);
                                let {
                                    arearange: i,
                                    gantt: l,
                                    map: h,
                                    mapbubble: c,
                                    treemap: p,
                                    xrange: m,
                                } = e.types;
                                i &&
                                    (i.prototype.keyToAxis = {
                                        low: "y",
                                        high: "y",
                                    }),
                                    l &&
                                        ((l.prototype.exportKey = "name"),
                                        (l.prototype.keyToAxis = {
                                            start: "x",
                                            end: "x",
                                        })),
                                    h && (h.prototype.exportKey = "name"),
                                    c && (c.prototype.exportKey = "name"),
                                    p && (p.prototype.exportKey = "name"),
                                    m && (m.prototype.keyToAxis = { x2: "x" });
                            }
                        },
                    };
                },
            ),
            o(
                e,
                "masters/modules/export-data.src.js",
                [
                    e["Core/Globals.js"],
                    e["Extensions/DownloadURL.js"],
                    e["Extensions/ExportData/ExportData.js"],
                ],
                function (t, e, o) {
                    return (
                        (t.dataURLtoBlob = t.dataURLtoBlob || e.dataURLtoBlob),
                        (t.downloadURL = t.downloadURL || e.downloadURL),
                        o.compose(t.Chart, t.Series),
                        t
                    );
                },
            );
    })
);
