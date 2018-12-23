<?php



namespace pawarenessc\bulidsign;



use pocketmine\event\Listener;

use pocketmine\plugin\PluginBase;


use pocketmine\Player;
use pocketmine\Server;

use pocketmine\utils\Config;

use pocketmine\tile\Tile;

use pocketmine\event\block\SignChangeEvent;

use pocketmine\event\player\PlayerInteractEvent;

use pocketmine\event\block\BlockBreakEvent;

use pocketmine\event\block\BlockPlaceEvent;

use pocketmine\item\Item;

use pocketmine\inventory\PlayerInventory;

use pocketmine\entity\Effect;

use pocketmine\level\Position;



class Main extends pluginBase implements Listener{









public function onEnable() {

 $this->getLogger()->info("=========================");
 $this->getLogger()->info("BulidSignを読み込みました");
 $this->getLogger()->info("v1.5.0");
 $this->getLogger()->info("=========================");

 $this->getServer()->getPluginManager()->registerEvents($this, $this);
 $this->xyz = new Config($this->getDataFolder() ."xyz.yml", Config::YAML);
 $this->bu = new Config($this->getDataFolder() ."name.yml", Config::YAML);
 $this->msg = new Config($this->getDataFolder()."Message.yml", Config::YAML,  

 

			[

 			"Message1" => "§c建築権限がありません", 



 			"Message2" => "§b建築権限を手に入れました！", 

 			]); 
 
 $this->xyz = new Config($this->getDataFolder()."sign.yml", Config::YAML,  

 

			[

 			"1" => "§b[TAP]", 

			"2" => "§a利用規約に同意", 

			"3" => "§c全て読みましたか？", 

			"4" => "§dお楽しみください！", 

 			]); 

}

public function onChangeEvent(SignChangeEvent $event){

$player = $event->getPlayer();

$name   = $player->getName();

if($event->getLine(0)=="bulid"){

if($player->isOp()){

$x = $event->getBlock()->x;

$y = $event->getBlock()->y;

$z = $event->getBlock()->z;

$this->xyz->set("".$x."".$y."".$z."");

$this->xyz->save();

$sign1 = $this->xyz->get("1");
$sign2 = $this->xyz->get("2");
$sign3 = $this->xyz->get("3");
$sign4 = $this->xyz->get("4");
$event->setLine(0, $sign1);

$event->setLine(1, $sign2);

$event->setLine(2, $sign3);

$event->setLine(3, $sign4);

$player->sendMessage("看板を生成しました");

}else{

$player->sendMessage("権限がありません");

  }

 }
}

public function onTouch(PlayerInteractEvent $event){

$blockid = $event->getBlock()->getID();

if($blockid == 63 || $blockid == 68){

$x = $event->getBlock()->x;

$y = $event->getBlock()->y;

$z = $event->getBlock()->z;

if($this->xyz->exists("".$x."".$y."".$z."")){

$player = $event->getPlayer();

$user = $player->getName();
$msg    = $this->msg->get("Message2");
$this->bu->set($user);
$this->bu->save();
$player->sendMessage($msg);

  }
 }
}
  public function onBlockBreak(BlockBreakEvent $event){



        $player = $event->getPlayer();



        $name   = $player->getName();

        

        $msg    = $this->msg->get("Message1");



        if($player->isOp() or $this->bu->exists($name)) {

		}else{

            $player->sendMessage($msg);



            $event->setCancelled();



        }



    }



    public function onBlockPlace(BlockPlaceEvent $event){



        $player = $event->getPlayer();



        $name   = $player->getName();



        $msg    = $this->msg->get("Message1");



        if($player->isOp() or $this->bu->exists($name)) {

		}else{

            $player->sendMessage($msg);



            $event->setCancelled();



        }



   }



 }
