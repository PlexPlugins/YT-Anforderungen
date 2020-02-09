<?php

namespace youtube;

//Basis
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\inventory;

//Event
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerDropEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerDeathEvent;

//Item - Enchantment - Effekte
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;

//utils
use pocketmine\utils\TextFormat as C;
use pocketmine\utils\Config;

//Commands
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

// FormAPI
use jojoe77777\FormAPI\SimpleForm;
use jojoe77777\FormAPI\CustomForm;
use joe77777\FormAPI;

//Sounds
use pocketmine\level\Sound\BlazeShootSound;
use pocketmine\level\Sound\AnvilFallSound;
use pocketmine\level\particle\DestroyBlockParticle;

//ColorGun
use pocketmine\event\entity\ProjectileHitBlockEvent;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;

//Block
use pocketmine\block\Block;
use pocketmine\item\SnowBall;

class Main extends PluginBase implements Listener{

  public $prefix = "§l§8[§l§cYou§4Tube§l§8] §r§l§7";

  public function onEnable(){
    $this->getServer()->getPluginManager()->registerEvents($this, $this);
    $this->getLogger()->info("Plugin ist aktiviert.");

    @mkdir($this->getDataFolder());
    $this->saveDefaultConfig();
    $this->getResource("config.yml");
  }

  public function onDisable(){
    $this->getLogger()->info("Plugin wurde deaktiviert.");
  }


  public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
    switch($cmd->getName()){
      case "yt":
        if($sender instanceof Player){
          if($sender->hasPermission("yt.setup")){
            $this->YouTubeUI($sender);
          }else{
            $sender->sendMessage($this->prefix . " §l§eDu hast nicht die benötigsten permissions.");
          }
        }else{
          $sender->sendMessage($this->prefix . " §l§eDas funktioniert nur InGame.");
        }
        break;
      case "discord":
        if($sender instanceof Player){
          $sender->sendMessage($this->prefix . $this->getConfig()->get("Discord"));
        }else{
          $sender->sendMessage($this->prefix . " §l§eDas funktioniert nur InGame.");
        }
        break;
      case "kanal":
        if($sender instanceof Player){
          $sender->sendMessage($this->prefix . $this->getConfig()->get("YouTube"));
        }else{
          $sender->sendMessage($this->prefix . " §l§eDas funktioniert nur InGame.");
        }
        break;
      case "author":
        if($sender instanceof Player){
          $sender->sendMessage($this->prefix . " §l§eDas Plugin wurde von §l§cV3rsucht§r §l§WasIstMarcel§r §l§egemacht!");
          $sender->sendPopup($this->prefix . " §l§eDas Plugin wurde von §l§cV3rsucht §l§egemacht!");
          $sender->addTitle("§8(§l§eAuthor§r§8)", "§l§cV3rsucht§r und §l§cWasIstMarcel");
          $sender->sendPopup($this->prefix . " §8(§l§eErreichbar§r§8) §l§cV3rsucht | Kai#0229 und WasIstMarcel#2002");
          $sender->sendMessage($this->prefix . " §l§eIn Discord unter: V3rsucht | Kai#0229 und WasIstMarcel#2002");
        }else{
          $sender->sendMessage($this->prefix . " §l§eDas funktioniert nur InGame."); /*Für Nicht in der Console!*/
        }
    }
    return true;
  }

  public function YouTubeUI($sender){
    $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
    $form = $api->createSimpleForm(function (Player $sender, int $data = null){
      $result = $data;
      if($result === null){
        return true;
      }
      switch($result){
        case 0:
          $sender->sendMessage($this->prefix . " §l§eDu hast die §cYou§4TubeUI §egeschlossen.");
          break;
      }
    });
    $form->setTitle($this->getConfig()->get("Title"));
    $form->setContent("\n Man Braucht " . $this->getConfig()->get("Abonnenten") . " Abonnenten \n \n \n" . $this->getConfig()->get("UnterText"));
    $form->addButton($this->getConfig()->get("Button"));
    $form->sendToPlayer($sender);
    return $form;
  }
}
