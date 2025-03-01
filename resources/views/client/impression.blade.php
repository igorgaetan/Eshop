<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    
    <title>Liste des produits</title>
      
    <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  </head>
  <body>
  


	<div id="invoice">
		<div class="invoice overflow-auto">
			<div style="min-width: 600px">
				<header>
					<div class="row">
             <div  style='width:100px;height:100px; margin-left:10px;'>
              <img src="{{file_get_contents(asset('logo.txt'))}}" style="width:100%; height:100%;" alt="bambino"/>
						  </div>
						<div class="col company-details">
							<h2 class="name">
								<a target="_blank" href="" style="color: #FF0000;">
								{{config('app.entreprise')}}
								</a>
							</h2>
							<div>{{config('app.adresse')}}</div>
							<div>{{config('app.tel')}}</div>
							<div>{{config('app.mail')}}</div>
						</div>
					</div>
				</header>
				<main>
					<div class="row contacts">
						<div class="col invoice-to">
							  <div class="text-gray-light">Liste des clients</div>
                    <div class="address"> Recherche: <span class="fw-bold"> @if(isset($search)){{$search}}@endif </span></div>
                    <div class="address">Date : {{$date->format('d-m-Y')}}</div>
			      </div>
					</div>
					<table class="table" >
						<thead>
							<tr>
                <th >Matr.</th>
                <th >Nom</th>
                <th >Ville</th>
                <th >Tel</th>
                <th >Point</th>
                <th >Tontine</th>
                                    
              </tr>
						</thead>
						<tbody>
                @foreach ($clientCartes as $clientCarte)
                        
                 <tr>
                      <td class="name" >{{$clientCarte->matr}}</td>
                      <td class="name">{{$clientCarte->nom}}</td>
                     
                  
                      <td class="name">{{$clientCarte->ville->libelle}}</td>
                      <td class="name">{{$clientCarte->mobile}}</td>
                      
                      <td class="name">{{formateur($clientCarte->point)}}</td>
                      <td class="name">{{formateur($clientCarte->montantTontine)}}</td>
                       
                  </tr>
                 @endforeach
							
						</tbody>
						<tfoot>
							<tr style="font-weight:bolder;">
								<td colspan="4">Total</td>
								<td > {{formateur($total)}} Client(s)</td>
							</tr>
						</tfoot>
					</table>
					
				
           
				</main>
				<footer>
					Merci !
				</footer>
			</div>
      
      <div> </div>
		</div>
	</div>
	<style>
			#invoice{
		padding: 30px;
        }

        .invoice {
            position: relative;
            background-color: #FFF;
            min-height: 680px;
            padding: 15px
        }

        .invoice header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #3989c6
        }

        .invoice .company-details {
            text-align: right
        }

        .invoice .company-details .name {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .contacts {
            margin-bottom: 20px
        }

        .invoice .invoice-to {
            text-align: left
        }

        .invoice .invoice-to .to {
            margin-top: 0;
            margin-bottom: 0
        }

        .invoice .invoice-details {
            text-align: right
        }

        .invoice .invoice-details .invoice-id {
            margin-top: 0;
            color: #3989c6
        }

        .invoice main {
            padding-bottom: 50px
        }

        .invoice main .thanks {
            margin-top: -100px;
            font-size: 2em;
            margin-bottom: 50px
        }

        .invoice main .notices {
            padding-left: 6px;
            border-left: 6px solid #3989c6
        }

        .invoice main .notices .notice {
            font-size: 1.2em
        }

        .invoice table {
            width:100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px
        }

        .invoice table td,.invoice table th {
            padding: 5px;
            background: #eee;
            border-bottom: 1px solid #fff
        }

        .invoice table th {
            white-space: nowrap;
            
            font-size: 16px
        }

        .invoice table td h3 {
            margin: 0;
            font-weight: 400;
            color: #3989c6;
            font-size: 1.2em
        }

        .invoice table .no,.invoice table .name,.invoice table .qty,.invoice table .total,.invoice table .unit {
            background-color: #FFF;
            text-align: center;
            font-size: 0.9em;
            border-bottom: 1px solid #000;
        }

        .invoice table .no {
            font-size: 0.9em;
           
        }

        .invoice table tbody tr:last-child td {
            border: none
        }

        .invoice table tfoot td {
            background: 0 0;
            border-bottom: none;
            white-space: nowrap;
            text-align: right;
            padding: 10px 20px;
            font-size: 0.9em;
            border-top: 1px solid #aaa
        }

        .invoice table tfoot tr:first-child td {
            border-top: none
        }

        .invoice table tfoot tr:last-child td {
            color: #3989c6;
            font-size: 0.9em;
            border-top: 1px solid #3989c6
        }

        .invoice table tfoot tr td:first-child {
            border: none
        }

        .invoice footer {
            width: 100%;
            text-align: center;
            color: #777;
            border-top: 1px solid #aaa;
            padding: 8px 0
        }

        @media print {
            .invoice {
                font-size: 11px!important;
                overflow: hidden!important;
            }
            .invoice th {
                font-size: 11px!important;
            }
            .hidden-print {
                display: none;
            }
            .invoice-to .to{
                font-size: 12px!important;
            }
            .invoice footer {
                position: absolute;
                bottom: 10px;
                page-break-after: always
            }

            .invoice>div:last-child {
                page-break-before: always
            }
            
        }
	</style>
	
	<script>
        const print=document.getElementById('printInvoice');
        print.addEventListener('click',function(){
				Popup(document.getElementById('invoice').outerHTML);
				function Popup(data) 
				{
					window.print();
					return true;
				}
			})
            

            
		
	</script>
  </body>
</html>