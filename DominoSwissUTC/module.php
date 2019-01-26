<?
include_once __DIR__ . '/../DominoSwissMXFEShutter/module.php'; 
    
    // Klassendefinition
class DominoSwissUTC extends DominoSwissMXFEShutter {
 
        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);
 
	    // Selbsterstellter Code

	   

        }
 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
		parent::Create();
        
		 // Property für ID
		 $this->RegisterPropertyInteger("ID", 0);
		 
		 // Profil für Temperatur und Lichtfühler
		 
		 
		
		 // Variablen für Fühler
		 $this->RegisterVariableInteger("light", "Lichtsensor", "~Illumination", "0");
		 $this->RegisterVariableFloat("temperatur", "Temperatur", "~Temperature", "1");
		 
		 $this->ConnectParent("{1252F612-CF3F-4995-A152-DA7BE31D4154}"); //DominoSwiss eGate
 
        }
 
        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }
 

	public function ReceiveData($JSONString) {
 
	    // Empfangene Daten vom Gateway/Splitter
	    $data = json_decode($JSONString);
 
	    // Datenverarbeitung und schreiben der Werte in die Statusvariablen
	    
	    if($data->Values->ID == $this->ReadPropertyInteger("ID"))
	    {
	        $command = $data->Values->Command;
	        switch($command)
	        {
	            case 35:
	                SetValue($this->GetIDForIdent("temperatur"), $data->Values->Value/2-20);
	                break;
	                
	            case 36:
	                SetValue($this->GetIDForIdent("light"), 0.1*10**(0.05*$data->Values->Value));
	                break;
	        }
	    }
 
	}

    }


?>
