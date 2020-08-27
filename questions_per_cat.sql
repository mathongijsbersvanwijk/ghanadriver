CATEGORIES
select count(d.doc_id), m.value from quagga_doc_meta dm, quagga_metavalue m, quagga_document d where dm.id_metavalue = m.id_metavalue and dm.doc_id = d.doc_id and m.id_metavar = 10 and d.doc_type="Q" group by m.value

select d.doc_id, m.value from quagga_doc_meta dm, quagga_metavalue m, quagga_document d where dm.id_metavalue = m.id_metavalue and dm.doc_id = d.doc_id and m.id_metavar = 10 and d.doc_type="Q"

select count(id), category_id from categorizations where categorizable_type = 'App\\Models\\Question' group by category_id order by category_id

SELECT dm.doc_id, mv.value FROM quagga_doc_meta dm, quagga_metavalue mv WHERE dm.id_metavalue = mv.id_metavalue and mv.id_metavar = 10 and doc_id = 319

TOTALS
SELECT DATE_FORMAT(exa_date_taken, '%Y-%m-%d'), count(exa_id) FROM `quagga_examination` group by DATE_FORMAT(exa_date_taken, '%Y-%m-%d') order by DATE_FORMAT(exa_date_taken, '%Y-%m-%d') desc

SELECT DATE_FORMAT(exa_date_taken, '%d-%m-%Y'), count(exa_id) FROM `quagga_examination` group by DATE_FORMAT(exa_date_taken, '%d-%m-%Y') order by DATE_FORMAT(exa_date_taken, '%d-%m-%Y') desc

SELECT tst_description, count(exa_id) FROM quagga_examination LEFT JOIN quagga_test ON tst_id = id where tst_id != 3 group by tst_id  order by tst_id asc
