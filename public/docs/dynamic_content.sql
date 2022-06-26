-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : sam. 25 juin 2022 à 22:04
-- Version du serveur : 8.0.29-0ubuntu0.22.04.2
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `action_culottee`
--

-- --------------------------------------------------------

--
-- Structure de la table `dynamic_content`
--

CREATE TABLE `dynamic_content` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dynamic_content`
--

INSERT INTO `dynamic_content` (`id`, `name`, `content`) VALUES
(4, 'partnerContent4', 'texte de about4'),
(5, 'partnerContent5', 'texte de about5'),
(9, 'home_main_presentation', '<p>L\'<strong>union</strong> fait la force et les évènements de ces derniers temps nous ont plus que jamais rappelé cet adage. A l\'initiative de Nathalie Paredes, une détaillante indépendante en lingerie, nous avons pu nous regrouper sur les réseaux sociaux et <strong>organiser des actions communes pour défendre, valoriser et promouvoir notre métier et notre savoir-faire.</strong></p>'),
(10, 'about_image1', '<p><img alt=\"\" src=\"http://localhost:8000/images/exemple-accueil.jpg\" style=\"height:62px;width:100px;\" /></p>'),
(11, 'about_image0', '<p><img alt=\"\" src=\"http://localhost:8000/images/map_icon.png\" style=\"height:377px;width:689px;\" /></p>'),
(12, 'about_nb_img', '3'),
(13, 'about_text_presentation', ''),
(14, 'about_image2', '<p><img alt=\"\" src=\"http://localhost:8000/images/map_icon.png\" style=\"height:377px;width:689px;\" /></p>'),
(15, 'about_image3', '<p><img alt=\"\" src=\"http://localhost:8000/images/home_presentation/fb98e7406266ab0af9334eb05d1afdcc.png\" style=\"height:169px;width:298px;\" /></p>'),
(16, 'about_image4', '<p><img alt=\"\" src=\"http://localhost:8000/images/founders/Audrey%20Maris.jpg\" style=\"width:1200px;\" /></p>'),
(17, 'about_img_1', ''),
(18, 'cgu', '<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 1 : Objet</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Les présentes « conditions générales d\'utilisation » ont pour objet l\'encadrement juridique de l’utilisation du site action-culottee.fr et de ses services.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Ce contrat est conclu entre :</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le gérant du site internet, ci-après désigné « l’Éditeur »,</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Toute personne physique ou morale souhaitant accéder au site et à ses services, ci-après appelé « l’Utilisateur ».</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Les conditions générales d\'utilisation doivent être acceptées par tout Utilisateur, et son accès au site vaut acceptation de ces conditions.</span></span></span></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 2 : Mentions légales</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\"><em>Pour les personnes morales :</em></span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le site action-culottee.fr est édité par l\'équipe Team Culottes, Apprenants WebForce3, sans capital propre, dont le siège social est situé au 36 boulevard Schneider 71200 LE CREUSOT.</span></span></span></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 3 : accès aux services</span></span></span></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L’Utilisateur du site action-culottee.fr a accès aux services suivants :</span></span></span></p>\n\n<ul>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Inscription</span></span></span></p>\n	</li>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Consultation des informations sur l\'association</span></span></span></p>\n	</li>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Consultation des évènements à venir de l\'association</span></span></span></p>\n	</li>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Utilisation de la carte dynamique</span></span></span></p>\n	</li>\n</ul>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Tout Utilisateur ayant accès a internet peut accéder gratuitement et depuis n’importe où au site. Les frais supportés par l’Utilisateur pour y accéder (connexion internet, matériel informatique, etc.) ne sont pas à la charge de l’Éditeur.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Les services suivants ne sont pas accessible pour l’Utilisateur que s’il est membre du site (c’est-à-dire qu’ile st identifié à l’aide de ses identifiants de connexion) :</span></span></span></p>\n\n<ul>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Ajout, édition et suppression de ses informations de compte</span></span></span></p>\n	</li>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Ajout, édition et suppression de ses points de vente</span></span></span></p>\n	</li>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Consultation des offres des marques partenaires de l\'association</span></span></span></p>\n	</li>\n</ul>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le site et ses différents services peuvent être interrompus ou suspendus par l’Éditeur, notamment à l’occasion d’une maintenance, sans obligation de préavis ou de justification.</span></span></span></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 4 : Responsabilité de l’Utilisateur</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L\'Utilisateur est responsable des risques liés à l’utilisation de son identifiant de connexion et de son mot de passe. </span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le mot de passe de l’Utilisateur doit rester secret. En cas de divulgation de mot de passe, l’Éditeur décline toute responsabilité.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L’Utilisateur assume l’entière responsabilité de l’utilisation qu’il fait des informations et contenus présents sur le site action-culottee.fr</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Tout usage du service par l\'Utilisateur ayant directement ou indirectement pour conséquence des dommages doit faire l\'objet d\'une indemnisation au profit du site.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le site permet aux membres de publier sur le site :</span></span></span></p>\n\n<ul>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Les informations concernant leurs points de vente</span></span></span></p>\n	</li>\n</ul>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le membre s’engage à tenir des propos respectueux des autres et de la loi et accepte que ces publications soient modérées ou refusées par l’Éditeur, sans obligation de justification. </span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">En publiant sur le site, l’Utilisateur cède à la société éditrice le droit non exclusif et gratuit de représenter, reproduire, adapter, modifier, diffuser et distribuer sa publication, directement ou par un tiers autorisé.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L’Éditeur s\'engage toutefois à citer le membre en cas d’utilisation de sa publication</span></span></span></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 5 : Responsabilité de l’Éditeur</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Tout dysfonctionnement du serveur ou du réseau ne peut engager la responsabilité de l’Éditeur.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">De même, la responsabilité du site ne peut être engagée en cas de force majeure ou du fait imprévisible et insurmontable d\'un tiers.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le site action-culottee.fr s\'engage à mettre en œuvre tous les moyens nécessaires pour garantir la sécurité et la confidentialité des données. Toutefois, il n’apporte pas une garantie de sécurité totale.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L’Éditeur se réserve la faculté d’une non-garantie de la fiabilité des sources, bien que les informations diffusées su le site soient réputées fiables.</span></span></span></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 6 : Propriété intellectuelle</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Les contenus du site action-culottee.fr (logos, textes, éléments graphiques, vidéos, etc.) son protégés par le droit d’auteur, en vertu du Code de la propriété intellectuelle.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L’Utilisateur devra obtenir l’autorisation de l’éditeur du site avant toute reproduction, copie ou publication de ces différents contenus.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Ces derniers peuvent être utilisés par les utilisateurs à des fins privées ; tout usage commercial est interdit.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L’Utilisateur est entièrement responsable de tout contenu qu’il met en ligne et il s’engage à ne pas porter atteinte à un tiers</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L’Éditeur du site se réserve le droit de modérer ou de supprimer librement et à tout moment les contenus mis en ligne par les utilisateurs, et ce sans justification.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">La carte interactive est est la propriété intellectuelle d\'<a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> et les données qu\'elle propose sont disponibles sous licence </span></span></span><a href=\"https://www.openstreetmap.org/copyright\">OdBL (<em>Open Database License) </em></a></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 7 : Données personnelles</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L’Utilisateur doit obligatoirement fournir des informations personnelles pour procéder à son inscription sur le site. </span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">L’adresse électronique (e-mail) de l’utilisateur pourra notamment être utilisée par le site action-culottee.fr pour la communication d’informations diverses et la gestion du compte.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">action-culottee.fr garantie le respect de la vie privée de l’utilisateur, conformément à la loi n°78-17 du 6 janvier 1978 relative à l\'informatique, aux fichiers et aux libertés.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le site est déclaré auprès de la CNIL sous le numéro suivant : 123456.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">En vertu des articles 39 et 40 de la loi en date du 6 janvier 1978, l\'Utilisateur dispose d\'un droit d\'accès, de rectification, de suppression et d\'opposition de ses données personnelles. L\'Utilisateur exerce ce droit via :</span></span></span></p>\n\n<ul>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Son espace personnel sur le site ;</span></span></span></p>\n	</li>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Par mail à admin@gmail.fr;</span></span></span></p>\n	</li>\n	<li>\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Par voie postale au </span></span></span></p>\n\n	<p>6, Rue Houdon</p>\n\n	<p>75018 Paris Île-de-France, FR</p>\n\n	<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">.</span></span></span></p>\n	</li>\n</ul>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 8 : Liens hypertextes</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Les domaines vers lesquels mènent les liens hypertextes présents sur le site n’engagent pas la responsabilité de l’Éditeur de action-culottee.fr, qui n’a pas de contrôle sur ces liens.</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Il est possible pour un tiers de créer un lien vers une page du site [votre site] sans autorisation expresse de l’éditeur.</span></span></span></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 9 : Évolution des conditions générales d’utilisation</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le site action-culottee.fr se réserve le droit de modifier les clauses de ces conditions générales d’utilisation à tout moment et sans justification.</span></span></span></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 10 : Durée du contrat</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">La durée du présent contrat est indéterminée. Le contrat produit ses effets à l\'égard de l\'Utilisateur à compter du début de l’utilisation du service.</span></span></span></p>\n\n<p> </p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:20pt;\">ARTICLE 11 : Droit applicable et juridiction compétente</span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">Le présent contrat dépend de la législation française. </span></span></span></p>\n\n<p><span style=\"color:#000000;\"><span style=\"font-family:Arial, Helvetica, sans-serif;\"><span style=\"font-size:11pt;\">En cas de litige non résolu à l’amiable entre l’Utilisateur et l’Éditeur, les tribunaux de Dijon sont compétents pour régler le contentieux.</span></span></span></p>\n\n<p> </p>'),
(19, 'legal-mentions', '<p>Merci de lire avec attention les différentes modalités d’utilisation du présent site avant d’y parcourir ses pages. En vous connectant sur ce site, vous acceptez sans réserves les présentes modalités. Aussi, conformément à l’article n°6 de la Loi n°2004-575 du 21 Juin 2004 pour la confiance dans l’économie numérique, les responsables du présent site internet <a href=\"http://www.action-culottee.fr\">www.action-culottee.fr</a> sont :</p>\n\n<h4><span style=\"color:#000000;\"><strong>Editeur du Site : </strong></span></h4>\n\n<p>Action Culottee Numéro de SIRET : 021520148 Responsable editorial : Audrey Marie 21 avenue de dijon 21150 Venarey Les Laumes Téléphone :0102030405 - Fax : 0102030405 Email : actionculottee@culotte.fr Site Web : <a href=\"http://www.action-culottee.fr\">www.action-culottee.fr</a></p>\n\n<h4><strong><span style=\"color:#000000;\">Hébergement :</span> </strong></h4>\n\n<p>Hébergeur : heberge2000 55 rue lavoisier 71200 Le Creusot Site Web : <a href=\"http://www.heberge2000.fr\">www.heberge2000.fr</a></p>\n\n<h4><span style=\"color:#000000;\"><strong>Développement</strong><strong> : </strong></span></h4>\n\n<p>La Team Culottes Adresse : 36 boulevard Schneider 71200 Le Creusot Site Web : <a href=\"http://www.passionculottes3d.fr\">www.passionculottes3d.fr</a></p>\n\n<h4><span style=\"color:#000000;\"><strong>Conditions d’utilisation : </strong></span></h4>\n\n<p>Ce site (<a href=\"http://www.action-culottee.fr\">www.action-culottee.fr</a>) est proposé en différents langages web (HTML, HTML5, Javascript, CSS, etc…) pour un meilleur confort d\'utilisation et un graphisme plus agréable, nous vous recommandons de recourir à des navigateurs modernes comme Internet explorer, Safari, Firefox, Google Chrome, etc… Les mentions légales ont été générées sur le site <a href=\"http://www.generateur-de-mentions-legales.com\" title=\"générateur de mentions légales pour site internet gratuit\">Générateur de mentions légales</a>, offert par <a href=\"http://welye.com\" title=\"imprimerie paris, imprimeur paris\">Welye</a>. <span style=\"color:#323333;\">Action Culottee<strong> </strong></span>met en œuvre tous les moyens dont elle dispose, pour assurer une information fiable et une mise à jour fiable de ses sites internet. Toutefois, des erreurs ou omissions peuvent survenir. L\'internaute devra donc s\'assurer de l\'exactitude des informations auprès de , et signaler toutes modifications du site qu\'il jugerait utile. n\'est en aucun cas responsable de l\'utilisation faite de ces informations, et de tout préjudice direct ou indirect pouvant en découler. <strong>Cookies</strong> : Le site <a href=\"http://www.action-culottee.fr\">www.action-culottee.fr</a> peut-être amené à vous demander l’acceptation des cookies pour des besoins de statistiques et d\'affichage. Un cookies est une information déposée sur votre disque dur par le serveur du site que vous visitez. Il contient plusieurs données qui sont stockées sur votre ordinateur dans un simple fichier texte auquel un serveur accède pour lire et enregistrer des informations . Certaines parties de ce site ne peuvent être fonctionnelles sans l’acceptation de cookies. <strong>Liens hypertextes :</strong> Les sites internet de peuvent offrir des liens vers d’autres sites internet ou d’autres ressources disponibles sur Internet. Action Culottee ne dispose d\'aucun moyen pour contrôler les sites en connexion avec ses sites internet. ne répond pas de la disponibilité de tels sites et sources externes, ni ne la garantit. Elle ne peut être tenue pour responsable de tout dommage, de quelque nature que ce soit, résultant du contenu de ces sites ou sources externes, et notamment des informations, produits ou services qu’ils proposent, ou de tout usage qui peut être fait de ces éléments. Les risques liés à cette utilisation incombent pleinement à l\'internaute, qui doit se conformer à leurs conditions d\'utilisation. Les utilisateurs, les abonnés et les visiteurs des sites internet de ne peuvent mettre en place un hyperlien en direction de ce site sans l\'autorisation expresse et préalable de Action Culottee. Dans l\'hypothèse où un utilisateur ou visiteur souhaiterait mettre en place un hyperlien en direction d’un des sites internet de Action Culottee, il lui appartiendra d\'adresser un email accessible sur le site afin de formuler sa demande de mise en place d\'un hyperlien. Action Culottee se réserve le droit d’accepter ou de refuser un hyperlien sans avoir à en justifier sa décision.</p>\n\n<h4><span style=\"color:#000000;\"><strong>Services fournis : </strong></span></h4>\n\n<p>L\'ensemble des activités de la société ainsi que ses informations sont présentés sur notre site <a href=\"http://www.action-culottee.fr\">www.action-culottee.fr</a>.</p>\n\n<p>Action Culottee s’efforce de fournir sur le site www.action-culottee.fr des informations aussi précises que possible. les renseignements figurant sur le site <a href=\"http://www.action-culottee.fr\">www.action-culottee.fr</a> ne sont pas exhaustifs et les photos non contractuelles. Ils sont donnés sous réserve de modifications ayant été apportées depuis leur mise en ligne. Par ailleurs, tous les informations indiquées sur le site www.action-culottee.fr<span style=\"color:#000000;\"><strong> </strong></span>sont données à titre indicatif, et sont susceptibles de changer ou d’évoluer sans préavis.</p>\n\n<h4><span style=\"color:#000000;\"><strong>Limitation contractuelles sur les données : </strong></span></h4>\n\n<p>Les informations contenues sur ce site sont aussi précises que possible et le site remis à jour à différentes périodes de l’année, mais peut toutefois contenir des inexactitudes ou des omissions. Si vous constatez une lacune, erreur ou ce qui parait être un dysfonctionnement, merci de bien vouloir le signaler par email, à l’adresse actionculottee@culotte.fr, en décrivant le problème de la manière la plus précise possible (page posant problème, type d’ordinateur et de navigateur utilisé, …). Tout contenu téléchargé se fait aux risques et périls de l\'utilisateur et sous sa seule responsabilité. En conséquence, ne saurait être tenu responsable d\'un quelconque dommage subi par l\'ordinateur de l\'utilisateur ou d\'une quelconque perte de données consécutives au téléchargement. <span style=\"color:#323333;\">De plus, l’utilisateur du site s’engage à accéder au site en utilisant un matériel récent, ne contenant pas de virus et avec un navigateur de dernière génération mis-à-jour</span> Les liens hypertextes mis en place dans le cadre du présent site internet en direction d\'autres ressources présentes sur le réseau Internet ne sauraient engager la responsabilité de Action Culottee.</p>\n\n<h4><span style=\"color:#000000;\"><strong>Propriété intellectuelle :</strong></span></h4>\n\n<p>Tout le contenu du présent sur le site <a href=\"http://www.action-culottee.fr\">www.action-culottee.fr</a>, incluant, de façon non limitative, les graphismes, images, textes, vidéos, animations, sons, logos, gifs et icônes ainsi que leur mise en forme sont la propriété exclusive de la société à l\'exception des marques, logos ou contenus appartenant à d\'autres sociétés partenaires ou auteurs. Toute reproduction, distribution, modification, adaptation, retransmission ou publication, même partielle, de ces différents éléments est strictement interdite sans l\'accord exprès par écrit de Action Culottee. Cette représentation ou reproduction, par quelque procédé que ce soit, constitue une contrefaçon sanctionnée par les articles L.335-2 et suivants du Code de la propriété intellectuelle. Le non-respect de cette interdiction constitue une contrefaçon pouvant engager la responsabilité civile et pénale du contrefacteur. En outre, les propriétaires des Contenus copiés pourraient intenter une action en justice à votre encontre.</p>\n\n<h4><span style=\"color:#000000;\"><strong>Déclaration à la CNIL : </strong></span></h4>\n\n<p>Conformément à la loi 78-17 du 6 janvier 1978 (modifiée par la loi 2004-801 du 6 août 2004 relative à la protection des personnes physiques à l\'égard des traitements de données à caractère personnel) relative à l\'informatique, aux fichiers et aux libertés, ce site n\'a pas fait l\'objet d\'une déclaration auprès de la Commission nationale de l\'informatique et des libertés (<a href=\"http://www.cnil.fr/\">www.cnil.fr</a>).</p>\n\n<h4><span style=\"color:#000000;\"><strong>Litiges : </strong></span></h4>\n\n<p>Les présentes conditions du site <a href=\"http://www.action-culottee.fr\">www.action-culottee.fr</a> sont régies par les lois françaises et toute contestation ou litiges qui pourraient naître de l\'interprétation ou de l\'exécution de celles-ci seront de la compétence exclusive des tribunaux dont dépend le siège social de la société. La langue de référence, pour le règlement de contentieux éventuels, est le français.</p>\n\n<h4><span style=\"color:#000000;\"><strong>Données personnelles :</strong></span></h4>\n\n<p>De manière générale, vous n’êtes pas tenu de nous communiquer vos données personnelles lorsque vous visitez notre site Internet <a href=\"http://www.action-culottee.fr\">www.action-culottee.fr</a>. Cependant, ce principe comporte certaines exceptions. En effet, pour certains services proposés par notre site, vous pouvez être amenés à nous communiquer certaines données telles que : votre nom, votre fonction, le nom de votre société, votre adresse électronique, et votre numéro de téléphone. Tel est le cas lorsque vous remplissez le formulaire qui vous est proposé en ligne, dans la rubrique « contact ». Dans tous les cas, vous pouvez refuser de fournir vos données personnelles. Dans ce cas, vous ne pourrez pas utiliser les services du site, notamment celui de solliciter des renseignements sur notre société, ou de recevoir les lettres d’information. Enfin, nous pouvons collecter de manière automatique certaines informations vous concernant lors d’une simple navigation sur notre site Internet, notamment : des informations concernant l’utilisation de notre site, comme les zones que vous visitez et les services auxquels vous accédez, votre adresse IP, le type de votre navigateur, vos temps d\'accès. De telles informations sont utilisées exclusivement à des fins de statistiques internes, de manière à améliorer la qualité des services qui vous sont proposés. Les bases de données sont protégées par les dispositions de la loi du 1er juillet 1998 transposant la directive 96/9 du 11 mars 1996 relative à la protection juridique des bases de données.</p>'),
(20, 'home_main_title', '<p>Culottés</p>'),
(21, 'home_missions_presentation', '<p>Accompagner les professionnels indépendants de l’habillement en lingerie en équipement et bien-être de la personne dans leur quotidien.</p>\n\n<p>Faciliter le partage, la réactivité et la communication entre nous pour créer une dynamique de groupe.</p>'),
(22, 'home_actions_img1', '<p><img alt=\"\" src=\"http://localhost:8000/images/castex-panty.jpg\" style=\"height:62px;width:100px;\" /><img alt=\"\" src=\"http://localhost:8000/images/castex-panty.jpg\" style=\"height:895px;\" /></p>'),
(23, 'home_poster_img1', '<p><img alt=\"\" src=\"http://localhost:8000/images/home_presentation/poster.jpg\" style=\"height:320px;width:180px;\" /></p>'),
(24, 'home_poster_img2', '<p><img alt=\"\" src=\"http://localhost:8000/images/home_presentation/poster.jpg\" style=\"height:320px;width:180px;\" /></p>'),
(25, 'home_poster_img3', '<p><img alt=\"\" src=\"http://localhost:8000/images/home_presentation/poster.jpg\" style=\"height:320px;width:180px;\" /></p>'),
(26, 'home_about_presentation_text', '<p>Le bureau officiel est aidé dans ses tâches par d\'autres détaillantes ou groupes de travail qui ont déjà œuvrés pour nos actions en 2021.</p>');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dynamic_content`
--
ALTER TABLE `dynamic_content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dynamic_content`
--
ALTER TABLE `dynamic_content`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
