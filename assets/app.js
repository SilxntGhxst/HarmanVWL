import './styles/app.css';

import * as Turbo from '@hotwired/turbo';
import $ from 'jquery';
import DataTable from 'datatables.net';

window.$ = window.jQuery = $;

document.addEventListener("turbo:load", function() {
    let tablas = $('.datatable');

    if (tablas.length) {
        tablas.each(function() {
            let tabla = $(this);
            if (!$.fn.DataTable.isDataTable(tabla)) {
                let urlEs = 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-MX.json';
                let urlEn = 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/en-GB.json';
                
                // Read lang from html tag
                let lang = document.documentElement.lang;
                let dataTableLangUrl = lang === 'es' ? urlEs : urlEn;

                tabla.DataTable({
                    language: {
                        url: dataTableLangUrl,
                    },
                    columnDefs: [
                        {
                            "targets": [-1],
                            "orderable": false
                        }
                    ]
                });
            }
        });
    }
});

console.log('This log comes from assets/app.js - Webpack Encore is running!');
