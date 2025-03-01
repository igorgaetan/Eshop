<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    <title> Commande #{{$commande->id}}</title>
    
     <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">
  
    <!-- Template Main CSS File -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  
  </head>
  <body>
  
  @guest()
    @if(!isset(request()->imprimer)) 
     	<div class="toolbar hidden-print">
    		<div class="text-right">
          <form>
            <input type="hidden" value="1" name="imprimer">
    			  <button type="submit" class="btn btn-info"><i class="fa fa-print"></i> Imprimer </button>
          </form>
    		</div>
    		<hr>
    	</div>
   @endif
 @endguest()
  
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
                            
                                <h4 class="to">{{$commande->nomClient}}</h4>
                                <div class="address">{{ substr($commande->addresse, 0, 20) }}</div>
                                <div class="email">{{$commande->mobile}}</div>
                            
						</div>
						<div class="col invoice-details">
							<h3 class="invoice-id">Commande #{{$commande->id}}</h3>
							<div class="date">Date : {{$commande->updated_at->format('d-m-Y H:i:s')}} </div>
						</div>
					</div>
					<table class="table" >
						<thead>
							<tr>
                @guest()
                  @if(!isset(request()->imprimer))
                 <th class="text-center align-middle hidden-print"> Preview </th>
                 @endif
                @endguest
								<th class="text-center fs-5 fw-bold">Code du Produit</th>
								<th class="text-center fs-5 fw-bold">Nom du Produit</th>
								<th class="text-center fs-5 fw-bold">Prix U.</th>
								<th class="text-center fs-5 fw-bold">Qt.</th>
								<th class="text-center fs-5 fw-bold">SubTotal</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($commande->ligneCommandes as $ligne)
							<tr>
                 @guest() 
                   @if(!isset(request()->imprimer))                                             
                      <th scope="row" class="text-center align-middle hidden-print">
                                  
                        @php
                        $photo= $ligne->produit->photos->first();
                        @endphp
                        @if($photo)
                            <a href="#"><img src="{{asset($photo->lienPhoto)}}" alt="" style="border-radius: 5px;max-width: 60px;;max-height: 60px;"></a> 
                        @else
                            <a href="#"><img src="{{asset("images/1719827982284.jpg")}}" alt="" style="border-radius: 5px;max-width: 60px;;max-height: 60px;"></a> 
                    
                        @endif
                      </th>
                   @endif
                 @endguest
								<td class="no text-center align-middle pt-2">{{substr($ligne->produit->codePro,0,3)}}-{{substr($ligne->produit->codePro,3)}} </td>
								<td class="name text-center align-middle pt-2">{{$ligne->produit->nomPro}}</td>
								<td class="unit text-center align-middle pt-2">{{number_format($ligne->produit->prix,'2','.',' ')}}</td>
								<td class="qty text-center align-middle pt-2">{{$ligne->qte}}</td>
								<td class="total text-center align-middle pt-2">{{number_format($ligne->produit->prix*$ligne->qte,'2','.',' ')}}</td>
							</tr>
                            @endforeach
							
						</tbody>
						<tfoot>
              
    							<tr>
    								
    								<td colspan="4">Total</td>
    								<td  class="text-end">{{formateur($commande->montant)}} FCFA</td>
    							</tr>
           
                   @if($commande->remise>0)
                   <tr>
      								 
      								<td colspan="4">Remise</td>
      								<td class="text-end">{{$commande->remise}} %</td>
      							</tr>
                   @endif
                   @if($commande->montantLivraison>0)
                   <tr>
      								
      								<td colspan="4">Frais Livraison</td>
      								<td class="text-end">{{formateur($commande->montantLivraison)}} FCFA</td>
      							</tr>
                   @endif
      							<tr style="font-weight:bolder;">
      								<td colspan="4">Net à payer</td>
      								<td>{{formateur((1-$commande->remise/100)*$commande->montant+$commande->montantLivraison)}} FCFA</td>
      							</tr>
						</tfoot>
					</table>
					
					
				</main>
				<footer>
					Merci !
				</footer>
			</div>
			<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
			<div></div>
 
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
             .invoice table .no,.invoice table .name,.invoice table .qty,.invoice table .total,.invoice table .unit {
           
            border-bottom: none;
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