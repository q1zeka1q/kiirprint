# Kirprint - Trükikoja CMS ja Tellimissüsteem

See on minu lõputöö raames tehtud reaalne projekt trükikojale. Ehitasin nullist valmis kodulehe koos tellimissüsteemi ja halduspaneeliga (CMS). 

## Peamised funktsioonid:

* **Mitmekeelsus (i18n):** Terve koduleht ja ka adminipaneel töötavad neljas keeles (eesti, vene, inglise ja soome). Kliendi valitud keel salvestatakse ja isegi andmebaasist tulev sisu muutub dünaamiliselt.
* **Targad hinnakalkulaatorid:** Lõin keerulise loogikaga JavaScript kalkulaatorid visiitkaartide ja voldikute (buklettide) jaoks. Süsteem arvestab automaatselt koguseid (astmelised soodustused), paberi paksust, trüki tüüpi (4+0 või 4+4) ja voltimise viise.
* **Mugav adminipaneel:** Veebilehe omanik saab ise muuta tekste, pilte ja mis kõige tähtsam – kalkulaatori hindu ja soodustusi otse adminipaneelist, ilma et peaks koodi puutuma.
* **Tellimuste süsteem:** Kalkulaatorist tulev info ja kliendi andmed edastatakse otse e-mailile tellimusena.

## Kasutatud tehnoloogiad:
* PHP
* MySQL (Andmebaas toodete, keelte ja seadete hoidmiseks)
* JavaScript (Kalkulaatorite reaalajas arvutamine)
* HTML / CSS
