<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    
    <title> Facture #{{$facture->id}}</title>
      
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
							  <div class="text-gray-light">Information du client:</div>
                @if($client)
                    <h4 class="to">{{$client->nom}}</h4>
                    <div class="address">{{$client->ville->libelle}}</div>
	                  <div class="email">{{$client->mobile}}</div>
                @else
                    <h4 class="to">######</h4>
                    <div class="address">######</div>
                    <div class="email">{{$facture->tel}}</div>
                @endif
			      </div>
						<div class="col invoice-details">
							<h3 class="invoice-id">Facture #{{$facture->id}}</h3>
							<div class="date">Date de facturation: @if($facture->paiementValid) {{$facture->updated_at->format('d-m-Y')}} @else En attente @endif</div>
						</div>
					</div>
					<table class="table" >
						<thead>
							<tr>
								<th class="fs-5 fw-bold">Code du Produit</th>
								<th class="fs-5 fw-bold">Nom du Produit</th>
								<th class="fs-5 fw-bold">Prix U.</th>
								<th class="fs-5 fw-bold">Qte.</th>
								<th class="fs-5 fw-bold">SubTotal</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($facture->ligneFactures as $ligne)
							<tr>
								<td class="no pt-2">{{substr($ligne->produit->codePro,0,3)}}-{{substr($ligne->produit->codePro,3)}} </td>
								<td class='name pt-2' >{{$ligne->produit->nomPro}}</td>
								<td class="unit pt-2">{{formateur($ligne->prix)}}</td>
								<td class="qty pt-2">{{$ligne->qte}}</td>
								<td class="total pt-2">{{formateur($ligne->prix*$ligne->qte)}}</td>
							</tr>
                            @endforeach
							
						</tbody>
						<tfoot>
							<tr>
								
								<td colspan="4">Total</td>
								<td  class="text-end pt-2">{{formateur($facture->montant)}} FCFA</td>
							</tr>
              @if($facture->tva>0)
							<tr>
								<td colspan="4">TVA</td>
								<td class="text-end pt-2" >{{$facture->tva}} %</td>
							</tr>
              @endif
              @if($facture->remise>0) 
                 <tr>
  								<td colspan="4">Remise</td>
  								<td class="text-end">{{$facture->remise}} %</td>
  							</tr>
              @endif
							<tr style="font-weight:bolder;">
								<td colspan="4">Net A Payer</td>
								<td > {{formateur(($facture->montant*(1-$facture->remise/100))*(1+$facture->tva/100))}} FCFA</td>
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