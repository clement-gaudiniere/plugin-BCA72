<?php
  /*
    POUR COMPRENDRE LE NOM DES INPUTS :
      [type]-[tableau]-[jour]-[debut/fin]
    AINSI POUR UN INPUT DE TYPE "time" DU TABLEAU 1 DE LA COLONNE DU LUNDI QUI MARQUE LE DEBUT DE L'HORAIRE :
      time-1-lundi-debut
  */
  global $wpdb;

  // On créer une liste des jours de la semaine
  $joursSemaine = ['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'];

  // On cherche les tableaux qui existent
  $planningTableaux = $wpdb->get_results('SELECT * FROM planning_tableaux');
 ?>
<section class="main" id="mainSectionTableaux">
  <?php
  // On affiche chaque tableaux avec ses horaires
  foreach($planningTableaux as $planningTableauxIncrement) {
    ?>
    <div class="part" id="part-<?= $planningTableauxIncrement->id ?>">
      <form method="post">
        <input type="text" name="title-<?= $planningTableauxIncrement->id ?>" id="title-<?= $planningTableauxIncrement->id ?>" value="<?= $planningTableauxIncrement->name ?>" placeholder="Titre du tableau">
        <table class="table-plan">
          <tr>
            <th>Lundi</th>
            <th>Mardi</th>
            <th>Mercredi</th>
            <th>Jeudi</th>
            <th>Vendredi</th>
            <th>Samedi</th>
            <th>Dimanche</th>
          </tr>
          <tr>
            <?php
            $planningHoraires = $wpdb->get_results('SELECT * FROM planning_horaires WHERE idTableau = '.$planningTableauxIncrement->id.' ORDER BY jour');
            $i = 0;
            foreach($planningHoraires as $planningHorairesIncrement) {
              ?>
              <td>
                <input type="time" id="time-<?= $planningTableauxIncrement->id ?>-<?= $joursSemaine[$i] ?>-debut" name="time-<?= $planningTableauxIncrement->id ?>-lundi-debut" value="<?= $planningHorairesIncrement->horaireDebut ?>">
                <span>à</span>
                <input type="time" id="time-<?= $planningTableauxIncrement->id ?>-<?= $joursSemaine[$i] ?>-fin" name="time-<?= $planningTableauxIncrement->id ?>-lundi-fin" value="<?= $planningHorairesIncrement->horaireFin ?>">
              </td>
              <?php
              $i += 1;
            }
             ?>
          </tr>
          <tr>
            <?php
            $i = 0;
            foreach($planningHoraires as $planningHorairesIncrement) {
              ?>
              <td class="comment"><textarea maxlength="150" placeholder="Commentaire..." id="comment-<?= $planningTableauxIncrement->id ?>-<?= $joursSemaine[$i] ?>"><?= $planningHorairesIncrement->commentaire ?></textarea></td>
              <?php
              $i += 1;
            }
             ?>
          </tr>
        </table>
        <div class="toolbar">
          <svg xmlns="http://www.w3.org/2000/svg" id="trash-<?= $planningTableauxIncrement->id ?>" x="0px" y="0px" viewBox="0 0 457.503 457.503" style="enable-background:new 0 0 457.503 457.503;" xml:space="preserve" class="trash">
            <g>
          		<path d="M381.575,57.067h-90.231C288.404,25.111,261.461,0,228.752,0C196.043,0,169.1,25.111,166.16,57.067H75.929    c-26.667,0-48.362,21.695-48.362,48.362c0,26.018,20.655,47.292,46.427,48.313v246.694c0,31.467,25.6,57.067,57.067,57.067    h195.381c31.467,0,57.067-25.6,57.067-57.067V153.741c25.772-1.02,46.427-22.294,46.427-48.313    C429.936,78.761,408.242,57.067,381.575,57.067z M165.841,376.817c0,8.013-6.496,14.509-14.508,14.509    c-8.013,0-14.508-6.496-14.508-14.509V186.113c0-8.013,6.496-14.508,14.508-14.508c8.013,0,14.508,6.496,14.508,14.508V376.817z     M243.26,376.817c0,8.013-6.496,14.509-14.508,14.509c-8.013,0-14.508-6.496-14.508-14.509V186.113    c0-8.013,6.496-14.508,14.508-14.508c8.013,0,14.508,6.496,14.508,14.508V376.817z M320.679,376.817    c0,8.013-6.496,14.509-14.508,14.509c-8.013,0-14.509-6.496-14.509-14.509V186.113c0-8.013,6.496-14.508,14.509-14.508    s14.508,6.496,14.508,14.508V376.817z"/>
          	</g>
          </svg>
          <button type="button" name="addException-<?= $planningTableauxIncrement->id ?>" class="btn btn-scd addException" id="addException-<?= $planningTableauxIncrement->id ?>">Ajouter une exception</button>
          <button type="button" name="save" class="btn btn-scd saveTable" id="save-<?= $planningTableauxIncrement->id ?>">Enregistrer</button>
        </div>
      </form>
    </div>
    <?php
  }
 ?>

 <div class="part nextTable"></div>

  <div class="part">
    <button id="ajouterPlanning" class="btn btn-main">
      <svg xmlns="http://www.w3.org/2000/svg" width="25px" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 489.8 489.8" style="enable-background:new 0 0 489.8 489.8;" xml:space="preserve">
      	<g>
      		<path d="M438.2,0H51.6C23.1,0,0,23.2,0,51.6v386.6c0,28.5,23.2,51.6,51.6,51.6h386.6c28.5,0,51.6-23.2,51.6-51.6V51.6    C489.8,23.2,466.6,0,438.2,0z M465.3,438.2c0,14.9-12.2,27.1-27.1,27.1H51.6c-14.9,0-27.1-12.2-27.1-27.1V51.6    c0-14.9,12.2-27.1,27.1-27.1h386.6c14.9,0,27.1,12.2,27.1,27.1V438.2z"/>
      		<path d="M337.4,232.7h-80.3v-80.3c0-6.8-5.5-12.3-12.3-12.3s-12.3,5.5-12.3,12.3v80.3h-80.3c-6.8,0-12.3,5.5-12.3,12.2    c0,6.8,5.5,12.3,12.3,12.3h80.3v80.3c0,6.8,5.5,12.3,12.3,12.3s12.3-5.5,12.3-12.3v-80.3h80.3c6.8,0,12.3-5.5,12.3-12.3    C349.7,238.1,344.2,232.7,337.4,232.7z"/>
      	</g>
      </svg>
      Ajouter un planning horaires
    </button>
  </div>
</section>

<div id="scriptBox">
  <?php include plugin_dir_path(__FILE__) . '../scripts/script.php'; ?>
</div>

<!-- Les fenêtres -->
<div id="confirmDelete">
  <div>
    <span>Êtes-vous sûr de vouloir supprimer ce tableau ?</span>
    <div class="flex">
      <button type="button" class="btn btn-danger" name="yes" id="deleteConfirmed">Oui</button>
      <button type="button" class="btn btn-scd" name="non" id="deleteCancelled">Non</button>
    </div>
  </div>
</div>

<div id="popupPlan">

</div>

<div id="loadingWindow">
  <div class="first"></div>
</div>