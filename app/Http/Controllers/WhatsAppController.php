namespace App\Http\Controllers;

use App\Services\Ultramsg;
use Illuminate\Http\Request;
use App\Models\commande;

class WhatsAppController extends Controller
{
    protected $ultramsg;

    public function __construct()
    {
        $this->ultramsg = new Ultramsg(/* paramètres nécessaires */);
    }

    public function sendMessage(Request $request, commande $commande)
    {
        $message = $request->input('message');
        $phone = $request->input('phone');

        $response = $this->ultramsg->sendMessage($phone, $message);

        return response()->json($response);
    }
}
