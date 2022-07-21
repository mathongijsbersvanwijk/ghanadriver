create view quagga_all_per_day as SELECT DATE_FORMAT(exa_date_taken, '%Y-%m-%d'), count(exa_id) FROM `quagga_examination` group by DATE_FORMAT(exa_date_taken, '%Y-%m-%d') order by exa_date_taken DESC

create view quagga_all_per_day_smart as SELECT DATE_FORMAT(exa_date_taken, '%Y-%m-%d'), count(exa_id) FROM `quagga_examination` where exa_mode > 4 group by DATE_FORMAT(exa_date_taken, '%Y-%m-%d') order by exa_date_taken DESC

