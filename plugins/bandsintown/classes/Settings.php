<?php
namespace bandsintown;

use Delight\Db\Throwable\IntegrityConstraintViolationException;
use HTMLPurifier;
use HTMLPurifier_Config;
use Ivy\Model;

class Settings extends Model
{

    public int $id;
    public string $key;
    public string $artists;
    public string $date;

    private string $token;

    protected string $table = "bandsintown";
    protected string $path = 'plugin/bandsintown';

    function list($key, $artist, $date)
    {
        $curl = new \Curl\Curl();
        $curl->get('https://rest.bandsintown.com/artists/' . $artist . '/events?app_id=' . $key . '&date=' . $date);
        if ($curl->error) {
            return 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
        } else {
            return $curl->response;
        }
    }

    /**
     * @throws IntegrityConstraintViolationException
     */
    function render(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && User::getAuth()->isLoggedIn()) {

            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);

            require_once Path::get('PROJECT_PATH') . _PLUGINS_PATH . 'gig/classes/item.php';
            $gig = new \Gig\Item();

            $item = new Item();

            foreach ($this->list() as $key => $value) {
                // insert
                $item_template = \Ivy\DB::$connection->selectRow('SELECT * FROM `item_templates` WHERE `plugin_url` = :plugin', ["Gig"]);
                $item->id = $item_template['id'];
                $gig_id = $gig->insert();
                $item_id = $item->insert($item->id, $gig_id);
                // update
                $item = new Item($item_id);
                $item->update($item->id, $item->template, null, $value->datetime);
                $gig->update([
                    $item->table_id,
                    date('Y-m-d', strtotime($value->datetime)),
                    date('H:i:s', strtotime($value->datetime)),
                    $value->venue->name,
                    $value->venue->street_address . ", " . $value->venue->postal_code . ", " . $value->venue->city . ", " . $value->venue->country,
                    $purifier->purify($_POST['subject'])
                ]);
            }

            Message::add('Rendered successfully', '');
        }
    }

}

?>
