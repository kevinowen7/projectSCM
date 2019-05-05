function showSaved(idT){
	//untuk otomatis scroll ketika calculate
	$("html, body").animate({scrollTop: $('#set').offset().top }, 500);
	
	
	$("#hasil").fadeOut(500, function() {
		$(this).hide();
		//menampilkan loading
		$("#loader").fadeIn(500, function() {
			$(this).removeClass("hide");
		});
		$("#save").fadeIn(500, function() {
			$(this).hide();
		});
		
		//mengkosongkan hasil chart 
		$('#scatterChart').remove();
		$('#remakeChart').append('<canvas id="scatterChart"></canvas>');
		$('#ChartRekomen').remove();
		$('#remakeChart1').append('<canvas id="ChartRekomen"></canvas>');
	})
	
  //membuka daftar hasil
  $("#hasil").fadeIn(500, function() {
	  	//clear all
		$("#result").empty();
		$("#resultRecomend").empty();
		$("#loader").fadeOut(100, function() {
			$(this).hide();
		});
		$(this).removeClass("hide");
		
		/*
		membuat chartnya
		
		*/		
		
		
		var jumlahKategori = parseInt(jumlahKategoriOn[idT]);

		//mengisi list varCost dan fixCost
		var varCost=varCostOn[idT].split("//");
		//fixedCost
		var fixedCost = fixedCostOn[idT].split("//");
		//nama kategori
		var namaKategori = namaKategoriOn[idT].split("//");
		
		varCost.pop();
		fixedCost.pop();
		namaKategori.pop();
		
		// untuk CHART UTAMA
		var scatterChartData = {		
		datasets: []
		}
		
		var listWarna = ['#00FF00','#0000FF','#FF0000','#FFFF00','#C0C0C0','#008000','#808000','#00FFFF','#008080','#800000','#000080','#FF00FF','#0000FF']

		var checkR =[]; 
		var listR=[];
		//bestDemand
		var listMaxDemand=[];


		//demand
		var demand = parseInt(demandOn[idT]);
		var demandList = [];

		//mengisi demandList
		for (var i = 0;i<varCost.length;i++){ 
		   demandList.push([0,demand]);
		}


		//load persamaan garisnya 
		var res = [];
		for(var i=0;i<varCost.length;i++){
		  res.push(varCost[i]+"x + " + fixedCost[i]);
		}

		//mencari titik potong dari smua kategori
		for (var i = 0; i < res.length; i++) { 
		  for (var j = i + 1 ; j < res.length; j++) {
			  try {
					var eq = algebra.parse(res[i]+"="+res[j]);
					var ans = eq.solveFor("x");
					if ((ans>0) && (ans<demand)){
						demandList[i].push(ans)
						checkR.push(ans)
					}
				} catch(err) {
					}
		  }
		}
		checkR.push(demand);
	
		checkR.sort(function(a, b){return a-b});

		//loop untuk append titik titik dari persamaan garis pada demand[0,a]
		var index=0;
		for (var index=0;index<varCost.length;index++){
		  //sorting listnya 
		  demandList[index].sort(function(a, b){return a-b});

		  scatterChartData.datasets.push({
				label: namaKategori[index]+" ",
				data: [],
				backgroundColor: [
				  listWarna[index],
				],
				borderColor: [
				  listWarna[index],
				],
				borderWidth: 1,
				fill : false
			});
		  
		  for (var i=0;i<demandList[index].length;i++){
			  var cariY = "y = "+varCost[index]+"*"+demandList[index][i]+"+"+ fixedCost[index];
			  var eq = algebra.parse(cariY);

			  var ans = eq.solveFor("y");
			  scatterChartData.datasets[index].data.push({x:demandList[index][i],y:ans});
			  
			  if (demandList[index][i]==demand){
				listMaxDemand.push({kategori:namaKategori[index],value:ans});
			  }
		  }
		  
		}


		//untuk rekomen lainnya mencari nilai nilai pada setiap kategori
		var index=0;
		for (var index=0;index<checkR.length;index++){
		  for (var i=0;i<varCost.length;i++){
			  var cariY = "y = "+varCost[i]+"*"+(checkR[index]-0.001)+"+"+ fixedCost[i];
			  var eq = algebra.parse(cariY);

			  var ans = eq.solveFor("y");
			  listR.push({kategori:namaKategori[i],value:ans,index:checkR[index],color:listWarna[i]});

		  }
		}
		
		//mencari nilai minimum dari array
		for(var i=0;i<listMaxDemand.length;i++){    
		 if(i == 0)
		 { 
		  var nilai_min = listMaxDemand[i].value;
		 }
		 else
		 {
				if(listMaxDemand[i].value< nilai_min)
				{
				  nilai_min = listMaxDemand[i].value;
				}
		 }
		} 
		
		
		// push value hasil to fillDB
		var hasilS ="";
		for(var i=0;i<listMaxDemand.length;i++){
			if(parseInt(listMaxDemand[i].value)==nilai_min){
				hasilS = hasilS+listMaxDemand[i].value +" (Best Kategori)//"
			} else {
				hasilS = hasilS+listMaxDemand[i].value+"//"
			}
		}
		
		//mengisi nilai result dari chart pertama
		for (var i=0;i<listMaxDemand.length;i++){
		  var hasil=``;
		  if(parseInt(listMaxDemand[i].value)==nilai_min){
			   hasil = `<div class="col-md-4 grid-margin stretch-card">
						  <div class="card">
							<div class="card-body">
							  <h4 class="card-title">`+listMaxDemand[i].kategori+`</h4>
							  <div class="media">
								<div class="media-body">
								  <i class="fa fa-minus fa-5x" style="color:`+listWarna[i]+`"></i>
								  <p class="card-text">Demand : `+demand+`</p>
								  <p class="card-text">FixedCost : `+fixedCost[i]+`</p>
								  <p class="card-text">VariabelCost : `+varCost[i]+`</p>
								  <p class="card-text"><u>Total Price : `+listMaxDemand[i].value+` <label class="badge badge-danger">Best Category</label></u></p>
								</div>
							  </div>
							</div>
						  </div>
						</div>`;
		  } else {
			   hasil = `<div class="col-md-4 grid-margin stretch-card">
					  <div class="card">
						<div class="card-body">
						  <h4 class="card-title">`+listMaxDemand[i].kategori+`</h4>
						  <div class="media">
							<div class="media-body">
							  <i class="fa fa-minus fa-5x" style="color:`+listWarna[i]+`"></i>
							  <p class="card-text">Demand : `+demand+`</p>
							  <p class="card-text">FixedCost : `+fixedCost[i]+`</p>
							  <p class="card-text">VariabelCost : `+varCost[i]+`</p>
							  <p class="card-text"><u>Total Price : `+listMaxDemand[i].value+`</u></p>
							</div>
						  </div>
						</div>
					  </div>
					</div>`;
		  }
		  $("#result").append(hasil);
		}

		//memasukan semua best category yang lainnya
		var recomended=[];
		for (var i=0;i<checkR.length;i++){
		  var valueTerbaik=1/0;
		  var kategoriTerbaik="";
		  var indexTerbaik="";
		  var colorTerbaik="";
		  for (var ii=0;ii<listR.length;ii++){
			  //mencari indexnya yang sama dengan nilai aslinya
			  if (listR[ii].index==checkR[i]){
				if (valueTerbaik>listR[ii].value){
					valueTerbaik = listR[ii].value
					kategoriTerbaik = listR[ii].kategori
					indexTerbaik = listR[ii].index
					colorTerbaik = listR[ii].color
				}
			  }
		  }
		  recomended.push({kategori:kategoriTerbaik,value:valueTerbaik,index:indexTerbaik,color:colorTerbaik});

		}
		// display option
		var scatterChartOptions = {
		  
		scales: {
		  xAxes: [{
			responsive: true,
			type: 'linear',
			position: 'bottom',
			ticks: {
			  beginAtZero: true,
			  max: demand,
			},
			scaleLabel: {
				display: true,
				labelString: 'Demand'
			}
		  }],
		  yAxes: [{
			responsive: true,
			ticks: {
			  beginAtZero: true
			},
			scaleLabel: {
				display: true,
				labelString: 'Price ($)'
			}
		  }]
		}
		}



		//push chart to UI
		if ($("#scatterChart").length) {
		var scatterChartCanvas = $("#scatterChart").get(0).getContext("2d");
		var scatterChart = new Chart(scatterChartCanvas, {
		  type: 'line',
		  data: scatterChartData,
		  options: scatterChartOptions
		});
		}


		//UNTUK CHART REKOMENDASI

		//mencari nilai index yang sama
		for (var i = 0; i < recomended.length; i++) { 
		  for (var j = i + 1 ; j < recomended.length; j++) {
			 if (recomended[i].kategori==recomended[j].kategori) { 
				  // aksi untuk elemen ganda } 
				  recomended[j].kategori='None'
		  }
		 }
		}


		var scatterChartData = {
			datasets: []
		}
		
		//mengenerate chart kedua
		for (var index=0;index<recomended.length;index++){
		  scatterChartData.datasets.push({
				label: recomended[index].kategori,
				data: [],
				backgroundColor: [
				  recomended[index].color,
				],
				borderColor: [
				  recomended[index].color,
				],
			});

		  
		  if(index==0){
			scatterChartData.datasets[index].data.push({x:0,y:1});
		  } else {
			scatterChartData.datasets[index].data.push({x:recomended[index-1].index,y:1});
		  }		  
		  
		  scatterChartData.datasets[index].data.push({x:recomended[index].index,y:1});
		}


		var scatterChartOptions = {
		legend: {
		   labels: {
			  filter: function(label) {
				 if (label.text=='www') return false;
			  }
		   }
		},
		responsive: true,
		maintainAspectRatio: false,
		scales: {
		  xAxes: [{
			type: 'linear',
			position: 'bottom',
			ticks: {
			  beginAtZero: true,
			  min:0,
			  max:demand,
			},
			scaleLabel: {
				display: true,
			},
			gridLines: {
					display:false
				} 
		  }],
		  yAxes: [{
			responsive: true,
			display:false,
			ticks: {
			  beginAtZero: true,
			  display:false,
			},
			scaleLabel: {
				display: true,
			},
			gridLines: {
					display:false
				} 
		  }]
		}
		}
		
		//push chart
		if ($("#ChartRekomen").length) {
		var scatterChartCanvas = $("#ChartRekomen").get(0).getContext("2d");
		var scatterChart = new Chart(scatterChartCanvas, {
		  type: 'line',
		  data: scatterChartData,
		  options: scatterChartOptions
		});
		}

		//membuat kesimpulan dari rekomendasi

		//mengubah desimal menjadi 2 angka di blkng koma
		for (var i = 0; i < recomended.length; i++) { 
		recomended[i].index = (Math.round(recomended[i].index*100)/100)
		}

		//mencari nilai index yang sama , untuk mengubah kategori none menjadi sama seperti sebelumnya
		for (var i = 0; i < recomended.length; i++) { 
		  for (var j = i + 1 ; j < recomended.length; j++) {
			 if ((recomended[i].color==recomended[j].color) && (recomended[j].kategori=="None")) { 
				  recomended[i].index = recomended[i].index + " , " +recomended[j-1].index+" - "+recomended[j].index
		  }
		 }
		}

		//mengisi nilai result rekomendasi
		for (var i=0;i<recomended.length;i++){
		  var hasil=``;
		  if(recomended[i].kategori!="None"){
			  if (i!=0){
			   hasil = `<div class="col-md-4 grid-margin stretch-card">
					  <div class="card">
						<div class="card-body">
						  <h4 class="card-title">`+recomended[i].kategori+`</h4>
						  <div class="media">
							<div class="media-body">
							  <i class="fa fa-minus fa-5x" style="color:`+recomended[i].color+`"></i>
							  <p class="card-text">Best Category in Range : `+recomended[i-1].index+` - `+recomended[i].index+`</p>
							</div>
						  </div>
						</div>
					  </div>
					</div>`;
			  } else {
			   hasil = `<div class="col-md-4 grid-margin stretch-card">
					  <div class="card">
						<div class="card-body">
						  <h4 class="card-title">`+recomended[i].kategori+`</h4>
						  <div class="media">
							<div class="media-body">
							  <i class="fa fa-minus fa-5x" style="color:`+recomended[i].color+`"></i>
							  <p class="card-text">Best Category in Range : `+`0 - `+recomended[i].index+`</p>
							</div>
						  </div>
						</div>
					  </div>
					</div>`;
			  }
		  }
		  
		  $("#resultRecomend").append(hasil);
		  $("#save").fadeIn(500, function() {
			$(this).removeClass("hide");
		  });
		}
		
  })
  
}

function deleteSaved(Id){
	//jika ingin delete muncul modal
	$("#modalDesc").html("Apakah anda yakin akan menghapus data "+Id+" ?");
	$("#modalConfirm").modal();

	//modal confirmation listener
	$("#confirmYes").on('click', function () {
		window.location="saved.php?delete="+Id
	});
}

$().ready(function() {
	//animasi pertama kali
	$("#mainPanel").fadeIn(500, function() {
		$(this).removeClass("hide");
	});

	//select table to work with jquery datatables
	var table = $('#tableSaved').DataTable({
		"aLengthMenu": [[10, 20, -1], [10, 20, "All"]],
		"order": [],
		"columnDefs": [
		{ orderable: false, targets: [0,1,2,3,4,6] }]
		
	})
	for (var i=namaKategoriOn.length-1;i>-1;i--){
		hasil1 = hasilOn[i].split("//").join("</br>");
		namaKategori1 = namaKategoriOn[i].split("//").join("</br>");
		fixedCost1 = fixedCostOn[i].split("//").join("</br>");
		varCost1 = varCostOn[i].split("//").join("</br>");
		
		table.row.add(["<p style='font-size:15px'>"+Id[i]+"</p>","<p style='font-size:15px'>"+namaKategori1+"</p>","<p style='font-size:15px'>"+fixedCost1+"</p>","<p style='font-size:15px'>"+varCost1+"</p>","<p style='font-size:15px'>"+hasil1+"</p>","<p style='font-size:15px'>"+demandOn[i]+"</p>","<button class='btn btn-primary btn-xs' onClick='showSaved("+i+")'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-xs' onClick='deleteSaved("+Id[i]+")'><i class='fa fa-trash'></i></button>"]).node().id = "data"+(i+1);

		table.draw();
	}


});