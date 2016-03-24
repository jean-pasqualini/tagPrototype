# tagPrototype

On essaie d'éviter sa

### Générale

**xtclick_s2** : 

    particulier => 1
    professionnel => 2
    [...]

**xiti_xtn2** :

    particulier => 1
    professionnel => 2

**xiti_xtpagetype** : "1-2-0" (???)

**xiti_xtsite** : "547787"

**xiti_page_name** : "accueil_professionnels" (valoriser par la page)

### CAS PARTICULIERS

#### CAS N°1 : Un tag de click (xtclick_event: C) qui cible un lien externe (xtclick_type : S)

    data-tagging="
    {
         type:'CLICK',
         params:
         {
             label':'commander::boutique_web_du_timbre::commander_creer_des_timbres_100_personnalises',
             'xtclick_event':'C',
             'xtclick_s2':1,
             'xtclick_type':'S'
         }
    }"
