select count(d.doc_id), m.value from quagga_doc_meta dm, quagga_metavalue m, quagga_document d where dm.id_metavalue = m.id_metavalue and dm.doc_id = d.doc_id and m.id_metavar = 10 and d.doc_type="Q" group by m.value

select d.doc_id, m.value from quagga_doc_meta dm, quagga_metavalue m, quagga_document d where dm.id_metavalue = m.id_metavalue and dm.doc_id = d.doc_id and m.id_metavar = 10 and d.doc_type="Q"

select count(id), category_id from categorizations where categorizable_type = 'App\\Models\\Question' group by category_id order by category_id

