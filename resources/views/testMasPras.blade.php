<!DOCTYPE html>
<html>
<head>
	<title>Test Mas Pras</title>
	<style type="text/css">
		table {
			font-family: arial, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		td, th {
			border: 1px solid #dddddd;
			text-align: left;
			padding: 8px;
		}

		tr:nth-child(even) {
			background-color: #dddddd;
		}
	</style>
</head>
<body>
	<table id="table">
		
	</table>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.0/moment.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var str = ['01/03/2018 09:06 AM','02/03/2018 09:20 AM','02/03/2018 09:20 AM','02/03/2018 09:20 AM','02/03/2018 04:31 PM','02/03/2018 05:15 PM','02/03/2018 08:01 PM','03/03/2018 07:10 PM','05/03/2018 08:45 AM','05/03/2018 01:50 PM','05/03/2018 09:30 AM','05/03/2018 02:30 PM','05/03/2018 04:02 PM','06/03/2018 08:12 AM','06/03/2018 08:26 AM','06/03/2018 09:30 AM','06/03/2018 10:55 AM','06/03/2018 03:05 PM','07/03/2018 08:12 AM','07/03/2018 08:35 AM','07/03/2018 08:40 AM','07/03/2018 10:55 AM','07/03/2018 02:19 PM','08/03/2018 07:55 AM','08/03/2018 09:43 AM','08/03/2018 10:01 AM','08/03/2018 04:39 PM','08/03/2018 04:40 PM','09/03/2018 07:30 AM','09/03/2018 07:30 AM','09/03/2018 08:26 AM','09/03/2018 09:19 AM','09/03/2018 10:30 AM','09/03/2018 10:34 AM','09/03/2018 01:45 PM','12/03/2018 09:02 AM','12/03/2018 09:02 AM','12/03/2018 09:32 AM','12/03/2018 08:59 AM','12/03/2018 09:34 AM','12/03/2018 09:34 AM','12/03/2018 09:42 AM','12/03/2018 11:11 AM','13/03/2018 08:51 AM','13/03/2018 09:52 AM','13/03/2018 09:52 AM','13/03/2018 09:52 AM','13/03/2018 09:52 AM','13/03/2018 09:52 AM','13/03/2018 09:52 AM','13/03/2018 09:52 AM','13/03/2018 09:52 AM','13/03/2018 09:52 AM','13/03/2018 09:52 AM','13/03/2018 10:19 AM','13/03/2018 10:35 AM','13/03/2018 01:31 PM','14/03/2018 08:53 AM','14/03/2018 09:42 AM','14/03/2018 10:25 AM','14/03/2018 10:20 AM','14/03/2018 01:20 PM','15/03/2018 07:52 AM','16/03/2018 09:50 AM','16/03/2018 01:00 PM','16/03/2018 01:00 PM','16/03/2018 01:50 PM','16/03/2018 01:50 PM','16/03/2018 02:40 PM','16/03/2018 02:45 PM','16/03/2018 05:42 PM','16/03/2018 05:56 PM','19/03/2018 09:40 AM','19/03/2018 11:00 AM','19/03/2018 12:15 PM','20/03/2018 10:30 AM','20/03/2018 01:00 PM','20/03/2018 02:19 PM','20/03/2018 02:59 PM','21/03/2018 03:29 PM','22/03/2018 08:51 AM','22/03/2018 01:26 PM','22/03/2018 01:46 PM','23/03/2018 08:35 AM','23/03/2018 09:40 AM','24/03/2018 09:09 AM','25/03/2018 11:53 AM','25/03/2018 04:00 PM','26/03/2018 09:35 AM','26/03/2018 10:28 AM','26/03/2018 01:54 PM','26/03/2018 08:00 PM','27/03/2018 10:23 AM','27/03/2018 10:35 AM','27/03/2018 01:43 PM','28/03/2018 10:04 AM','28/03/2018 11:44 AM','28/03/2018 03:48 PM','28/03/2018 04:09 PM','29/03/2018 02:08 PM','30/03/2018 10:55 AM','31/03/2018 09:59 AM','31/03/2018 10:04 AM','31/03/2018 12:13 PM']; 
		var end = ['01/03/2018 11:41 AM','05/03/2018 01:36 PM','05/03/2018 05:12 PM','05/03/2018 04:10 PM','03/03/2018 04:19 PM','02/03/2018 08:49 PM','05/03/2018 03:17 PM','03/03/2018 09:09 PM','05/03/2018 11:49 AM','05/03/2018 03:40 PM','05/03/2018 06:03 PM','07/03/2018 05:51 PM','06/03/2018 03:37 PM','06/03/2018 04:36 PM','07/03/2018 01:51 PM','06/03/2018 12:29 PM','06/03/2018 03:57 PM','06/03/2018 04:31 PM','07/03/2018 12:16 PM','07/03/2018 11:14 AM','08/03/2018 12:36 PM','07/03/2018 02:14 PM','07/03/2018 06:12 PM','08/03/2018 09:56 AM','08/03/2018 02:30 PM','08/03/2018 04:54 PM','09/03/2018 11:09 AM','08/03/2018 07:12 PM','11/03/2018 04:22 PM','11/03/2018 02:23 PM','09/03/2018 11:05 AM','10/03/2018 01:10 PM','09/03/2018 03:25 PM','09/03/2018 02:25 PM','09/03/2018 10:01 PM','12/03/2018 06:43 PM','12/03/2018 10:59 AM','12/03/2018 11:20 AM','15/03/2018 03:53 PM','15/03/2018 03:53 PM','15/03/2018 06:12 PM','12/03/2018 04:35 PM','15/03/2018 06:12 PM','14/03/2018 11:58 AM','14/03/2018 10:31 AM','19/03/2018 12:06 PM','14/03/2018 12:33 PM','22/03/2018 11:48 AM','15/03/2018 11:23 AM','19/03/2018 03:04 PM','23/03/2018 11:35 AM','27/03/2018 07:12 PM','19/03/2018 11:39 AM','22/03/2018 10:13 AM','13/03/2018 02:26 PM','13/03/2018 05:31 PM','14/03/2018 11:40 AM','14/03/2018 11:23 AM','14/03/2018 08:13 PM','14/03/2018 03:43 PM','14/03/2018 04:11 PM','15/03/2018 11:39 AM','16/03/2018 04:20 PM','16/03/2018 01:58 PM','16/03/2018 01:27 PM','17/03/2018 10:52 AM','16/03/2018 03:35 PM','16/03/2018 08:56 PM','16/03/2018 03:47 PM','16/03/2018 03:35 PM','20/03/2018 02:03 PM','17/03/2018 12:24 PM','19/03/2018 04:25 PM','19/03/2018 05:02 PM','19/03/2018 01:28 PM','21/03/2018 06:19 PM','20/03/2018 04:00 PM','20/03/2018 08:30 PM','22/03/2018 02:04 PM','22/03/2018 10:00 AM','22/03/2018 04:44 PM','23/03/2018 04:55 PM','22/03/2018 07:33 PM','23/03/2018 03:27 PM','23/03/2018 05:21 PM','25/03/2018 12:59 PM','25/03/2018 01:59 PM','25/03/2018 07:57 PM','26/03/2018 01:50 PM','26/03/2018 04:17 PM','27/03/2018 12:29 PM','27/03/2018 12:33 PM','27/03/2018 03:25 PM','03/04/2018 11:53 AM','27/03/2018 06:44 PM','28/03/2018 01:49 PM','28/03/2018 01:40 PM','28/03/2018 06:58 PM','29/03/2018 02:27 PM','31/03/2018 11:59 PM','31/03/2018 11:59 PM','31/03/2018 04:51 PM','31/03/2018 06:55 PM','31/03/2018 01:32 PM'];
		var loc = ['ATM KCP Maja Rangkasbitung','ATM Cabang Pekanbaru','ATM Transmart Pekanbaru','ATM Mall SKA','ATM Pom Bensin Imbanagara','ATM KCP Cicadas','ATM KK Panjalu ','ATM KCP Cikurubuk','ATM KCP Ciranjang','ATM K.Kas UNMA','ATM Mobil Kas Edukasi Bekasi','ATM RSUD Kab. Bekasi','ATM KK Cikarang Utara','ATM KK Cisoka','ATM Pemkot Bandung','ATM Pom Bensin Imbanagara','ATM SPBU Limo Cinere Depok','ATM RSUD Ciamis','ATM KK MUTIARA GADING','ATM K.Kas UNMA','ATM KK Cikarang Utara','ATM Pemkot Bandung','ATM KK CIOMAS','ATM Cabang Cimahi','ATM KCP Cempaka Mas','ATM KCP Cibadak','ATM SPBU BAGBAGAN','ATM Cabang Cibinong','ATM Unpad Jatinangor','ATM IPDN 2','ATM KCP Gedebage','ATM Mall Serang/ATM SPBU KASEMEN','ATM Jatinangor Town Square','ATM RSUD Dr. Slamet Garut','NO DATA','ATM KCP Ciasem','ATM KCP Galaxi','ATM KK Pemda Ciamis','ATM Cabang Cilegon 2','ATM Cabang Cilegon 1','ATM Mayofield Mall Cilegon / ATM Cabang Cilegon 3','ATM KCP Cikande','ATM KK Serdang / Alfamart Metro Cilegon','ATM KCP Tanjungkerta','ATM KCP Pangleseran','ATM KCP Sagaranten','ATM KCP Cicurug','ATM Pemkab Sukabumi','ATM Cikukulu','ATM KK KIDANG KENCANA','ATM KK PURABAYA','ATM RSUD Jampang Kulon','ATM Cabang Pelabuhan Ratu 2','ATM SPBU BAGBAGAN','ATM KCP Kebonjati','ATM KCP Bintaro','ATM Cabang Surabaya','ATM KCP Sukaraja - Tasikmalaya','ATM Royal Farma Serang 985','ATM KCP Karangampel','ATM KK CIGOMBONG','ATM KCP Pasar Baru Jakarta','ATM KCP Baros Cimahi','ATM KCP Medan Satria','ATM KCP Rancah','ATM Kas Mobil Tasikmalaya','ATM KK Waroeng Tigaraksa','ATM Borma Padalarang','ATM KCP Cicadas','ATM KK Waroeng Tigaraksa','ATM KK Cigadung','ATM KCP Gedung Sate','ATM KK Cikupa','ATM KK Lemahabang wadas','ATM Cabang Utama Bandung 2','ATM KCP Picung','ATM KK Abdul Halim  Majalengka','ATM Giant Extra Kenten / ATM Graha Tiara','NO DATA','ATM Cabang Denpasar','ATM KCP Pondok Indah','ATM RS Bersalin Ratna Komala','NO DATA','ATM KK Tambun Utara','ATM Alfamart Pintu Toll Timur Cilegon','ATM PU / ATM Alfamart Pasar Kemis','ATM Cimangkok Square','ATM Griya Dinasty Kiaracondong','ATM Stasiun Hall','ATM Cikarang Plaza','ATM KK Cikarang Utara','ATM Cabang Majalaya','ATM Giant Extra Kenten / ATM Graha Tiara','ATM KK CARIU','ATM Mega Mall Bekasi','ATM SPBU BAGBAGAN','ATM PDAM Tirtawening','ATM Kapetakan (SPBU Kapetakan)','ATM KCP Tanjungkerta','ATM Bandara Raden Intan II','ATM CTC Jasa Marga','ATM KCP Gedung Sate','ATM Kantor Pos Cabang Tangerang','ATM Serang City / ATM Serang City Trade Center'];
		var atm = ['A361','A357','B388','B389','B324','A060','B327','A314','A207','A332','A379','A341','B378','B314','A025','B324','A276','A308','B291','A332','B378','A025','B280','A008','A262','A306','B454','A034','A050','B453','A184','A158','A127','A309','B456','A228','A397','B328','A442','A043','A301','A350','B416','B428','A234','A241','A353','A389','B331','B332','B333','B429','B441','B454','A461','A406','A091','B341','A426','A162','B279','A270','A240','A248','A171','A380','B202','A374','A060','B202','A137','A317','B167','B269','A013','A245','B305','B437','B260','A408','A263','B376','B456','B276','B417','B433','B371','A396','A412','B443','B378','A124','B437','B278','A076','B454','A290','B364','B428','B407','A027','A317','B419','B348'];

		var append = "";
		append = append + "<tr>";
		append = append + "	<th>No.</th>";
		append = append + "	<th>ID ATM</th>";
		append = append + "	<th>Location</th>";
		append = append + "	<th>Start</th>";
		append = append + "	<th>End</th>";
		append = append + "	<th>Down (second)</th>";
		append = append + "	<th>Must (second)</th>";
		append = append + "	<th>SLA</th>";
		append = append + "</tr>";

		var SLA = 0;
		for(var i = 0; i < str.length; i++){
			append = append + "<tr>";
			append = append + "	<td>" + (i+1) + "</td>";
			append = append + "	<td>" + atm[i] + "</td>";
			append = append + "	<td>" + loc[i] + "</td>";
			// append = append + "	<td>" + str[i] + "</td>";
			// append = append + "	<td>" + end[i] + "</td>";
			append = append + "	<td>" + moment(str[i],'DD/MM/YYYY hh:mm A').format('HH:mm DD-MM-YYYY') + "</td>";
			append = append + "	<td>" + moment(end[i],'DD/MM/YYYY hh:mm A').format('HH:mm DD-MM-YYYY') + "</td>";
			var duration = moment.duration(moment(end[i],'DD/MM/YYYY hh:mm A').diff(moment(str[i],'DD/MM/YYYY hh:mm A')));
			var second = duration.asSeconds();
			append = append + "	<td>" + second + "</td>";
			append = append + "	<td>" + (moment().daysInMonth(3) * 24 * 3600) + "</td>";
			append = append + "	<td>" + precisionRound(((((moment().daysInMonth(3) * 24 * 3600) - second) / (moment().daysInMonth(3) * 24 * 3600)) * 100),2) + "</td>";
			append = append + "</tr>";

			SLA = SLA + precisionRound(((((moment().daysInMonth(3) * 24 * 3600) - second) / (moment().daysInMonth(3) * 24 * 3600)) * 100),2);
		}

		
		append = append + "<tr>";
		append = append + "	<td colspan='6'></td>";
		append = append + "	<td><b>Total SLA</b></td>";
		append = append + "	<td>" + precisionRound(SLA/str.length,2) + "</td>";
		append = append + "</tr>";

		$("#table").append(append);

		function precisionRound(number, precision) {
			var factor = Math.pow(10, precision);
			return Math.round(number * factor) / factor;
		}

	});
</script>
</html>