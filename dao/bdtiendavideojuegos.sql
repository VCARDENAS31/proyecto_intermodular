-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2026 a las 21:02:38
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdtiendavideojuegos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones`
--

CREATE TABLE `cupones` (
  `id_cupon` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descuento_porcentaje` int(11) NOT NULL,
  `fecha_caducidad` date NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `cupones`
--

INSERT INTO `cupones` (`id_cupon`, `codigo`, `descuento_porcentaje`, `fecha_caducidad`, `activo`) VALUES
(5, 'FREE5', 5, '2026-11-01', 1),
(15, 'NUEVAPRUEBA', 15, '2026-07-12', 1),
(17, 'BIENVENIDO2026', 11, '2026-06-07', 1),
(18, 'VERANO2026', 12, '2026-06-26', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cupones_usuarios`
--

CREATE TABLE `cupones_usuarios` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_cupon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos`
--

CREATE TABLE `detalles_pedidos` (
  `id_detalle` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total_linea` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `detalles_pedidos`
--

INSERT INTO `detalles_pedidos` (`id_detalle`, `pedido_id`, `producto_id`, `precio_unitario`, `cantidad`, `total_linea`) VALUES
(57, 69, 182, 529.00, 1, 529.00),
(58, 69, 183, 449.99, 1, 449.99),
(59, 69, 212, 59.99, 1, 59.99),
(60, 70, 17, 34.99, 2, 69.98),
(61, 70, 22, 49.99, 1, 49.99),
(62, 70, 66, 60.00, 1, 60.00),
(63, 70, 123, 29.99, 1, 29.99),
(64, 71, 159, 345.00, 1, 345.00),
(65, 71, 149, 55.00, 1, 55.00),
(66, 72, 215, 29.99, 1, 29.99),
(67, 72, 196, 34.99, 1, 34.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cupon_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','enviado','reparto','entregado') NOT NULL DEFAULT 'pendiente',
  `fecha_pedido` datetime NOT NULL DEFAULT current_timestamp(),
  `direccion_envio` varchar(255) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `nombre_cliente` varchar(150) NOT NULL,
  `metodo_pago` enum('tarjeta','contra') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `usuario_id`, `cupon_id`, `total`, `estado`, `fecha_pedido`, `direccion_envio`, `telefono`, `nombre_cliente`, `metodo_pago`) VALUES
(69, 54, NULL, 1041.97, 'pendiente', '2026-05-15 20:53:50', 'calle portugal, 12312, Lisboa (34534)', '678677766', 'Pepe Lima Ferreira', 'tarjeta'),
(70, 54, NULL, 212.95, 'pendiente', '2026-05-15 20:55:40', 'calle portugal, 12312, Lisboa (78879)', '967567656', 'Pepe Lima Ferreira', 'contra'),
(71, 55, NULL, 402.99, 'pendiente', '2026-05-15 20:58:31', 'calle zaragoza, 3290, Zaragoza (31231)', '987655432', 'Javier Liras Lara', 'contra'),
(72, 56, NULL, 67.97, 'pendiente', '2026-05-15 21:00:29', 'calle madrid, 12312, Madrid (34223)', '645345543', 'Cristiano Dos Santos Aveiro', 'tarjeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL,
  `categoria` varchar(100) DEFAULT NULL,
  `descripcion` varchar(1000) DEFAULT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `plataforma` enum('PS5','Xbox','Switch') NOT NULL,
  `tieneLector` tinyint(1) DEFAULT NULL,
  `almacenamiento` varchar(50) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `precio`, `stock`, `tipo`, `categoria`, `descripcion`, `img_url`, `plataforma`, `tieneLector`, `almacenamiento`, `slug`) VALUES
(2, 'NBA 2K26', 59.90, 16, 'Juego', 'Deportes', 'Experimenta la emoción del baloncesto con gráficos hiperrealistas y animaciones precisas.\r\nControla cada jugada con nuevas mecánicas ofensivas y defensivas.\r\nModo MyCareer mejorado con historia envolvente.\r\nCompite online contra jugadores de todo el mundo.\r\nAmbientes y estadios recreados con gran detalle.\r\nIdeal para los amantes del baloncesto competitivo.', 'productos/videojuegos/deporte/nba-2k-26-caratula.webp', 'Xbox', NULL, NULL, 'nba-2k26-xbox'),
(3, 'F1 24', 65.00, 10, 'Juego', 'Deportes', 'Siente la velocidad extrema de la Fórmula 1 con físicas realistas.\r\nCompite en circuitos oficiales con condiciones dinámicas.\r\nModo carrera profundo con gestión de equipo incluida.\r\nGráficos espectaculares que reflejan cada detalle del coche.\r\nIA desafiante que pone a prueba tus habilidades.\r\nLa experiencia definitiva de conducción profesional.', 'productos/videojuegos/deporte/f1-24-caratula.webp', 'PS5', NULL, NULL, 'f1-24-ps5'),
(4, 'Gran Turismo 7', 69.99, 20, 'Juego', 'Deportes', 'El simulador de conducción más completo con vehículos reales licenciados.\r\nDisfruta de cientos de coches y circuitos detallados.\r\nFísicas avanzadas que recrean la conducción real.\r\nModo campaña y competiciones online.\r\nGráficos impresionantes con tecnología ray tracing.\r\nPerfecto para fans del motor y la velocidad.', 'productos/videojuegos/deporte/gran-turismo-7-caratula.webp', 'PS5', NULL, NULL, 'gran-turismo-7-ps5'),
(5, 'Forza Horizon 5', 59.99, 30, 'Juego', 'Deportes', 'Explora un mundo abierto lleno de carreras y desafíos en México.\r\nGran variedad de vehículos y personalización avanzada.\r\nEventos dinámicos y clima cambiante.\r\nModo online con amigos y competiciones.\r\nGráficos vibrantes y detallados.\r\nDiversión asegurada en cada carrera.', 'productos/videojuegos/deporte/forza-horizon-5-caratula.webp', 'Xbox', NULL, NULL, 'forza-horizon-5-xbox'),
(6, 'Mario Strikers: Battle League', 49.99, 12, 'Juego', 'Deportes', 'Fútbol arcade lleno de acción con personajes de Nintendo.\r\nPartidos caóticos con habilidades especiales.\r\nMultijugador local y online.\r\nEstilo visual colorido y dinámico.\r\nJugabilidad rápida y divertida.\r\nPerfecto para jugar con amigos.', 'productos/videojuegos/deporte/Mario-Strikers-caratula.webp', 'Switch', NULL, NULL, 'mario-strikers-battle-league-switch'),
(7, 'WWE 2K24', 55.00, 8, 'Juego', 'Deportes', 'Vive la emoción de la lucha libre con gráficos realistas.\r\nGran variedad de luchadores y modos de juego.\r\nCrea tu propio personaje y carrera.\r\nAnimaciones mejoradas y combates fluidos.\r\nModo online competitivo.\r\nIdeal para fans del wrestling.', 'productos/videojuegos/deporte/www-2k-24-caratula.webp', 'PS5', NULL, NULL, 'wwe-2k24-ps5'),
(8, 'Madden NFL 26', 60.00, 10, 'Juego', 'Deportes', 'Simulación completa de fútbol americano con jugadas estratégicas.\r\nControl total del equipo y gestión táctica.\r\nModos online y offline.\r\nGráficos realistas con estadios auténticos.\r\nIA avanzada para mayor desafío.\r\nPerfecto para fans de la NFL.', 'productos/videojuegos/deporte/madden-nfl-26-caratula.webp', 'Xbox', NULL, NULL, 'madden-nfl-26-xbox'),
(9, 'Tony Hawks Pro Skater 1+2', 39.99, 5, 'Juego', 'Deportes', 'Remasterización de los clásicos juegos de skate más icónicos.\r\nTrucos fluidos y jugabilidad mejorada.\r\nMapas originales con gráficos modernos.\r\nModo multijugador online.\r\nGran banda sonora.\r\nDiversión arcade asegurada.', 'productos/videojuegos/deporte/tony-hawks-pro-skater-1mas2.webp', 'Xbox', NULL, NULL, 'tony-hawks-pro-skater-1-2-xbox'),
(10, 'Rocket League Ultimate', 29.99, 100, 'Juego', 'Deportes', 'Fútbol con coches a toda velocidad en partidos caóticos.\r\nMecánicas simples pero altamente competitivas.\r\nMultijugador online muy activo.\r\nPersonalización de vehículos.\r\nPartidas rápidas y adictivas.\r\nIdeal para jugar con amigos.', 'productos/videojuegos/deporte/rocket-league-ultimate-caratula.webp', 'Switch', NULL, NULL, 'rocket-league-ultimate-switch'),
(11, 'Call of Duty: Black Ops 6', 79.99, 50, 'Juego', 'Acción', 'Sumérgete en combates intensos en primera persona con una narrativa cinematográfica.\r\nCampaña llena de acción con misiones dinámicas y momentos épicos.\r\nModo multijugador competitivo con mapas variados.\r\nArmas personalizables y progresión avanzada.\r\nGráficos realistas con efectos visuales de última generación.\r\nUna experiencia imprescindible para amantes de los shooters.', 'productos/videojuegos/accion/cod-bo6-caratula.webp', 'PS5', NULL, NULL, 'call-of-duty-black-ops-6-ps5'),
(12, 'Doom Eternal', 29.99, 15, 'Juego', 'Acción', 'Acción frenética contra hordas de demonios en escenarios infernales.\r\nMovimiento rápido y combate agresivo que recompensa la habilidad.\r\nGran variedad de armas devastadoras.\r\nBanda sonora intensa que acompaña cada batalla.\r\nDiseño de niveles vertical y dinámico.\r\nUna experiencia pura de adrenalina sin pausas.', 'productos/videojuegos/accion/doom-eternal-caratula.webp', 'Xbox', NULL, NULL, 'doom-eternal-xbox'),
(13, 'Halo Infinite', 39.99, 20, 'Juego', 'Acción', 'La legendaria saga regresa con mundo abierto y libertad total.\r\nExplora un entorno amplio lleno de misiones y secretos.\r\nCombate táctico con armas futuristas.\r\nModo multijugador competitivo y cooperativo.\r\nGráficos espectaculares y narrativa envolvente.\r\nUna aventura imprescindible para fans de la saga.', 'productos/videojuegos/accion/halo-infinite-caratula.webp', 'Xbox', NULL, NULL, 'halo-infinite-xbox'),
(14, 'Devil May Cry 5', 25.00, 10, 'Juego', 'Acción', 'Hack and slash de alta velocidad con estilo espectacular.\r\nCombates fluidos con combos impresionantes.\r\nPersonajes carismáticos y narrativa intensa.\r\nGran variedad de armas y habilidades.\r\nGráficos estilizados con efectos llamativos.\r\nAcción pura con un ritmo frenético.', 'productos/videojuegos/accion/devil-may-cry-6-caratula.webp', 'PS5', NULL, NULL, 'devil-may-cry-5-ps5'),
(15, 'Sekiro: Shadows Die Twice', 59.99, 12, 'Juego', 'Acción', 'Viaje desafiante en el Japón feudal lleno de enemigos letales.\r\nSistema de combate preciso basado en reflejos.\r\nExploración de escenarios detallados.\r\nHistoria profunda de honor y venganza.\r\nGran dificultad que recompensa la habilidad.\r\nUna experiencia intensa y satisfactoria.', 'productos/videojuegos/accion/sekiro-shadows-die-twice-caratula.webp', 'Xbox', NULL, NULL, 'sekiro-shadows-die-twice-xbox'),
(16, 'Bayonetta 3', 49.99, 8, 'Juego', 'Acción', 'Acción espectacular con combates llenos de magia y estilo.\r\nEnfréntate a enemigos gigantescos en batallas épicas.\r\nSistema de combate fluido y dinámico.\r\nEscenarios variados y llenos de detalles.\r\nPersonaje carismático con gran personalidad.\r\nUna experiencia única dentro del género.', 'productos/videojuegos/accion/bayonetta-3-caratula.webp', 'Switch', NULL, NULL, 'bayonetta-3-switch'),
(17, 'Sifu', 34.99, 13, 'Juego', 'Acción', 'Domina el Kung Fu en una historia de venganza intensa.\r\nSistema de combate técnico y desafiante.\r\nMecánica de envejecimiento única.\r\nDiseño artístico minimalista y elegante.\r\nNiveles diseñados para rejugabilidad.\r\nIdeal para jugadores que buscan reto.', 'productos/videojuegos/accion/sifu-caratula.webp', 'PS5', NULL, NULL, 'sifu-ps5'),
(18, 'Wolfenstein II', 19.99, 20, 'Juego', 'Acción', 'Shooter ambientado en una realidad alternativa dominada por enemigos.\r\nHistoria intensa con narrativa profunda.\r\nArmas variadas y combates estratégicos.\r\nEscenarios detallados y ambientación inmersiva.\r\nAcción constante y ritmo dinámico.\r\nUn clásico moderno del género.', 'productos/videojuegos/accion/wolfensteinII-caratula.webp', 'Xbox', NULL, NULL, 'wolfenstein-ii-xbox'),
(19, 'Astral Chain', 45.00, 5, 'Juego', 'Acción', 'Combate futurista combinando acción y estrategia.\r\nControla personajes y entidades al mismo tiempo.\r\nHistoria envolvente con estilo anime.\r\nEscenarios urbanos detallados.\r\nSistema de combate innovador.\r\nExclusivo con una experiencia única.', 'productos/videojuegos/accion/astral-chain-caratula.webp', 'Switch', NULL, NULL, 'astral-chain-switch'),
(20, 'Hades', 24.99, 40, 'Juego', 'Acción', 'Roguelike de acción con combates rápidos y adictivos.\r\nHistoria basada en la mitología griega.\r\nGran variedad de armas y habilidades.\r\nDiseño artístico impresionante.\r\nAlta rejugabilidad en cada partida.\r\nUna joya imprescindible del género indie.', 'productos/videojuegos/accion/hades-caratula.webp', 'Switch', NULL, NULL, 'hades-switch'),
(21, 'The Legend of Zelda: TotK', 69.99, 30, 'Juego', 'Aventura', 'Embárcate en una aventura épica en un mundo abierto lleno de misterios.\r\nExplora cielos y tierras con total libertad.\r\nResuelve puzles y enfréntate a enemigos desafiantes.\r\nHistoria profunda con personajes memorables.\r\nGráficos artísticos y detallados.\r\nUna experiencia imprescindible para amantes de la aventura.', 'productos/videojuegos/aventura/zelda-tears-of-the-kingdom-caratula.webp', 'Switch', NULL, NULL, 'the-legend-of-zelda-totk-switch'),
(22, 'Uncharted: Legacy of Thieves', 49.99, 19, 'Juego', 'Aventura', 'Viaja por el mundo en busca de tesoros perdidos y secretos antiguos.\r\nAventura cinematográfica con acción constante.\r\nEscenarios espectaculares y detallados.\r\nPersonajes carismáticos y narrativa envolvente.\r\nCombina exploración, plataformas y combate.\r\nUna experiencia digna de una película de acción.', 'productos/videojuegos/aventura/uncharted-legacy-of-thieves-caratula.webp', 'PS5', NULL, NULL, 'uncharted-legacy-of-thieves-ps5'),
(23, 'God of War Ragnarok', 59.99, 25, 'Juego', 'Aventura', 'Vive la épica historia de Kratos y Atreus en su viaje final.\r\nCombates intensos con enemigos mitológicos.\r\nNarrativa profunda cargada de emociones.\r\nEscenarios impresionantes inspirados en la mitología nórdica.\r\nSistema de progresión y habilidades mejorado.\r\nUna obra maestra de la aventura moderna.', 'productos/videojuegos/aventura/god-of-war-ragnarok-caratula.webp', 'PS5', NULL, NULL, 'god-of-war-ragnarok-ps5'),
(24, 'Horizon Forbidden West', 49.99, 15, 'Juego', 'Aventura', 'Explora un mundo postapocalíptico dominado por máquinas.\r\nCaza criaturas robóticas con armas avanzadas.\r\nHistoria rica y llena de misterio.\r\nEntornos abiertos llenos de vida y detalle.\r\nSistema de combate estratégico.\r\nUna aventura visualmente espectacular.', 'productos/videojuegos/aventura/horizon-forbidden-caratula.webp', 'PS5', NULL, NULL, 'horizon-forbidden-west-ps5'),
(25, 'Ghost of Tsushima', 39.99, 10, 'Juego', 'Aventura', 'Conviértete en un samurái en la isla de Tsushima.\r\nCombate con espada en duelos intensos.\r\nExplora paisajes hermosos inspirados en Japón.\r\nHistoria de honor, sacrificio y venganza.\r\nEstilo visual cinematográfico.\r\nUna experiencia inmersiva única.', 'productos/videojuegos/aventura/ghost-of-tsushima-caratula.webp', 'PS5', NULL, NULL, 'ghost-of-tsushima-ps5'),
(26, 'Sea of Thieves', 39.99, 25, 'Juego', 'Aventura', 'Vive la vida pirata en un mundo abierto multijugador.\r\nNavega, lucha y busca tesoros con tu tripulación.\r\nEventos dinámicos en alta mar.\r\nGran libertad de exploración.\r\nEstilo visual colorido y divertido.\r\nPerfecto para jugar con amigos.', 'productos/videojuegos/aventura/sea-of-thieves-caratula.webp', 'Xbox', NULL, NULL, 'sea-of-thieves-xbox'),
(27, 'Prince of Persia: The Lost Crown', 45.00, 12, 'Juego', 'Aventura', 'Acción y plataformas en una aventura ambientada en Persia.\r\nCombate ágil con habilidades especiales.\r\nExplora escenarios en 2.5D llenos de secretos.\r\nHistoria inspirada en la mitología.\r\nDiseño artístico llamativo.\r\nUna mezcla perfecta de acción y exploración.', 'productos/videojuegos/aventura/prince-of-persia-the-lost-crown-caratula.webp', 'Switch', NULL, NULL, 'prince-of-persia-the-lost-crown-switch'),
(28, 'Assassins Creed Valhalla', 35.00, 20, 'Juego', 'Aventura', 'Conquista Inglaterra como un feroz guerrero vikingo.\r\nExplora un mundo abierto lleno de misiones.\r\nCombate brutal con armas y habilidades.\r\nConstruye y gestiona tu asentamiento.\r\nNarrativa épica basada en la historia.\r\nUna aventura extensa y envolvente.', 'productos/videojuegos/aventura/assassin-creed-valhalla.webp', 'Xbox', NULL, NULL, 'assassins-creed-valhalla-xbox'),
(29, 'Ratchet & Clank', 59.99, 15, 'Juego', 'Aventura', 'Salta entre dimensiones en una aventura llena de acción.\r\nArmas creativas y combate dinámico.\r\nEscenarios futuristas con gran detalle.\r\nHistoria divertida y personajes carismáticos.\r\nGráficos de nueva generación.\r\nUna experiencia espectacular y entretenida.', 'productos/videojuegos/aventura/ratchet-and-clank-caratula.webp', 'PS5', NULL, NULL, 'ratchet-y-clank-ps5'),
(30, 'Super Mario Odyssey', 49.99, 10, 'Juego', 'Aventura', 'Acompaña a Mario en un viaje por mundos increíbles.\r\nExplora escenarios llenos de secretos.\r\nMecánicas innovadoras con Cappy.\r\nDiseño creativo y variado.\r\nJugabilidad accesible y divertida.\r\nUn clásico moderno de plataformas en 3D.', 'productos/videojuegos/aventura/super-mario-odyssey-caratula.webp', 'Switch', NULL, NULL, 'super-mario-odyssey-switch'),
(31, 'Resident Evil Village', 39.99, 17, 'Juego', 'Terror', 'Sobrevive a una pesadilla en un pueblo lleno de criaturas aterradoras.\r\nAmbiente oscuro con tensión constante.\r\nCombate y gestión de recursos limitados.\r\nHistoria inquietante llena de misterios.\r\nGráficos realistas que aumentan la inmersión.\r\nUna experiencia de horror intensa e inolvidable.', 'productos/videojuegos/terror/resident-evil-8-caratula.webp', 'PS5', NULL, NULL, 'resident-evil-village-ps5'),
(32, 'Silent Hill 2 Remake', 69.99, 12, 'Juego', 'Terror', 'Sumérgete en una historia de terror psicológico profundamente perturbadora.\r\nExplora una ciudad envuelta en niebla y secretos.\r\nNarrativa intensa cargada de simbolismo.\r\nAmbiente opresivo que genera tensión constante.\r\nSonido y diseño que potencian el miedo.\r\nUna obra maestra del terror moderno.', 'productos/videojuegos/terror/silent-hill-2-remake-caratula.webp', 'PS5', NULL, NULL, 'silent-hill-2-remake-ps5'),
(33, 'Dead Space Remake', 59.99, 10, 'Juego', 'Terror', 'Vive el horror espacial en una nave infestada de criaturas.\r\nAmbiente claustrofóbico y angustiante.\r\nCombate estratégico con recursos limitados.\r\nDiseño de sonido que incrementa la tensión.\r\nGráficos renovados con gran detalle.\r\nUna experiencia aterradora en el espacio.', 'productos/videojuegos/terror/dead-space-remake-caratula.webp', 'Xbox', NULL, NULL, 'dead-space-remake-xbox'),
(34, 'Alan Wake 2', 55.00, 15, 'Juego', 'Terror', 'Un thriller psicológico que mezcla realidad y pesadilla.\r\nHistoria profunda con múltiples capas narrativas.\r\nAmbiente oscuro y sobrenatural.\r\nExploración e investigación constantes.\r\nNarrativa envolvente con giros inesperados.\r\nIdeal para amantes del terror psicológico.', 'productos/videojuegos/terror/alan-wake-2-caratula.webp', 'Xbox', NULL, NULL, 'alan-wake-2-xbox'),
(35, 'Little Nightmares II', 29.99, 25, 'Juego', 'Terror', 'Ayuda a Mono a sobrevivir en un mundo oscuro y distorsionado.\r\nPlataformas con puzles inquietantes.\r\nDiseño artístico único y perturbador.\r\nHistoria contada de forma visual.\r\nAmbiente opresivo y misterioso.\r\nUna experiencia corta pero impactante.', 'productos/videojuegos/terror/little-nightmaresII-caratula.webp', 'Switch', NULL, NULL, 'little-nightmares-ii-switch'),
(36, 'Amnesia: The Bunker', 24.99, 20, 'Juego', 'Terror', 'Terror puro en un búnker durante la guerra.\r\nOscuridad constante con recursos limitados.\r\nSistema de supervivencia realista.\r\nEnemigos impredecibles que generan tensión.\r\nExploración lenta y estratégica.\r\nUna experiencia intensa y angustiante.', 'productos/videojuegos/terror/amnesia-the-bunker-caratula.webp', 'Xbox', NULL, NULL, 'amnesia-the-bunker-xbox'),
(37, 'Alien: Isolation', 29.99, 10, 'Juego', 'Terror', 'Escapa de una criatura letal en una estación espacial.\r\nIA del enemigo impredecible.\r\nAmbiente tenso y claustrofóbico.\r\nJuego basado en sigilo y supervivencia.\r\nDiseño sonoro que eleva el miedo.\r\nUn clásico del terror moderno.', 'productos/videojuegos/terror/alien-isolation-caratula.webp', 'PS5', NULL, NULL, 'alien-isolation-ps5'),
(38, 'The Evil Within 2', 19.99, 12, 'Juego', 'Terror', 'Adéntrate en un mundo de pesadillas para salvar a tu hija.\r\nAmbiente psicológico oscuro.\r\nCombate y exploración combinados.\r\nHistoria intensa y emocional.\r\nEscenarios surrealistas y perturbadores.\r\nUna experiencia inquietante y profunda.', 'productos/videojuegos/terror/the-evil-within-2-caratula.webp', 'Xbox', NULL, NULL, 'the-evil-within-2-xbox'),
(39, 'Fatal Frame: Black Water', 39.99, 8, 'Juego', 'Terror', 'Exorciza espíritus usando una cámara especial.\r\nAmbiente japonés cargado de misterio.\r\nTerror psicológico con exploración.\r\nDiseño sonoro envolvente.\r\nHistoria oscura y atrapante.\r\nUna experiencia diferente dentro del género.', 'productos/videojuegos/terror/fatal-frame-black-water-caratula.webp', 'Switch', NULL, NULL, 'fatal-frame-black-water-switch'),
(40, 'Luigis Mansion 3', 49.99, 15, 'Juego', 'Terror', 'Explora un hotel encantado lleno de fantasmas.\r\nCombina humor y terror ligero.\r\nPuzles y exploración en cada planta.\r\nPersonajes carismáticos y divertidos.\r\nDiseño visual atractivo.\r\nIdeal para todas las edades.', 'productos/videojuegos/terror/luigis-mansion-3-caratula.webp', 'Switch', NULL, NULL, 'luigis-mansion-3-switch'),
(41, 'Baldurs Gate 3', 59.99, 40, 'Juego', 'RPG', 'Sumérgete en un mundo de fantasía basado en Dungeons & Dragons.\r\nDecisiones que afectan el desarrollo de la historia.\r\nCombate táctico por turnos profundo.\r\nGran libertad para crear tu personaje.\r\nExploración llena de secretos y misiones.\r\nUna experiencia RPG completa y envolvente.', 'productos/videojuegos/rpg/baldurs-gate-3-caratula.webp', 'PS5', NULL, NULL, 'baldurs-gate-3-ps5'),
(42, 'Elden Ring', 65.00, 30, 'Juego', 'RPG', 'Explora un mundo abierto oscuro lleno de misterios.\r\nCombate desafiante con gran profundidad.\r\nDiseño de niveles interconectados.\r\nHistoria contada de forma ambiental.\r\nGran variedad de armas y habilidades.\r\nUna experiencia exigente y épica.', 'productos/videojuegos/rpg/elden-ring-caratula.webp', 'Xbox', NULL, NULL, 'elden-ring-xbox'),
(43, 'The Witcher 3', 29.99, 25, 'Juego', 'RPG', 'Embárcate en la historia del brujo Geralt de Rivia.\r\nMundo abierto lleno de misiones y decisiones.\r\nNarrativa profunda con múltiples finales.\r\nCombate dinámico con magia y espada.\r\nPersonajes memorables.\r\nUn clásico imprescindible del RPG moderno.', 'productos/videojuegos/rpg/the-witcher-3-caratula.webp', 'Xbox', NULL, NULL, 'the-witcher-3-xbox'),
(44, 'Cyberpunk 2077', 49.99, 20, 'Juego', 'RPG', 'Adéntrate en una ciudad futurista llena de peligros.\r\nPersonaliza tu personaje con mejoras cibernéticas.\r\nHistoria compleja con múltiples caminos.\r\nCombate variado con armas y habilidades.\r\nAmbiente urbano detallado.\r\nUna experiencia inmersiva en un mundo cyberpunk.', 'productos\\videojuegos\\rpg\\cyberpunk-2077-caratula.webp', 'PS5', NULL, NULL, 'cyberpunk-2077-ps5'),
(45, 'Final Fantasy VII Rebirth', 69.99, 15, 'Juego', 'RPG', 'Continúa la épica historia de Cloud y sus compañeros.\r\nCombate dinámico con mezcla de acción y estrategia.\r\nEscenarios impresionantes y detallados.\r\nNarrativa emocional y profunda.\r\nPersonajes icónicos del universo Final Fantasy.\r\nUna aventura inolvidable.', 'productos/videojuegos/rpg/final-fantasy-VII-rebirth.webp', 'PS5', NULL, NULL, 'final-fantasy-vii-rebirth-ps5'),
(46, 'Starfield', 69.99, 20, 'Juego', 'RPG', 'Explora el espacio en un RPG de gran escala.\r\nViaja entre planetas con total libertad.\r\nCrea tu personaje y define su historia.\r\nSistema de combate variado.\r\nGran cantidad de misiones y contenido.\r\nUna experiencia espacial única.', 'productos/videojuegos/rpg/starfield-caratula.webp', 'Xbox', NULL, NULL, 'starfield-xbox'),
(47, 'Persona 5 Royal', 45.00, 10, 'Juego', 'RPG', 'Vive la doble vida de un estudiante en Tokio.\r\nSistema de combate por turnos elegante.\r\nRelaciones sociales que afectan la historia.\r\nEstilo artístico único.\r\nNarrativa profunda y envolvente.\r\nUna joya del RPG japonés.', 'productos/videojuegos/rpg/persona5-caratula.webp', 'Switch', NULL, NULL, 'persona-5-royal-switch'),
(48, 'Dragon Age: The Veilguard', 69.99, 15, 'Juego', 'RPG', 'Salva el mundo de Thedas de una amenaza divina.\r\nToma decisiones que cambian la historia.\r\nCombate estratégico con habilidades.\r\nExploración de un mundo rico en lore.\r\nPersonajes complejos.\r\nUna experiencia RPG épica.', 'productos/videojuegos/rpg/dragon-age-4-caratula.webp', 'Xbox', NULL, NULL, 'dragon-age-the-veilguard-xbox'),
(49, 'Skyrim: Anniversary', 39.99, 25, 'Juego', 'RPG', 'Explora un mundo lleno de dragones y magia.\r\nLibertad total para crear tu aventura.\r\nSistema de progresión abierto.\r\nGran cantidad de misiones secundarias.\r\nAmbiente inmersivo.\r\nUn clásico atemporal del RPG.', 'productos/videojuegos/rpg/skyrim-anniversary-caratula.webp', 'Switch', NULL, NULL, 'skyrim-anniversary-switch'),
(50, 'Octopath Traveler II', 55.00, 12, 'Juego', 'RPG', 'Vive ocho historias diferentes en un mundo único.\r\nCombate por turnos estratégico.\r\nEstilo visual HD-2D espectacular.\r\nPersonajes con historias profundas.\r\nExploración rica en contenido.\r\nUna experiencia RPG diferente y memorable.', 'productos/videojuegos/rpg/octopath-travelerII-caratula.webp', 'Switch', NULL, NULL, 'octopath-traveler-ii-switch'),
(51, 'FIFA 26', 69.99, 25, 'Juego', 'Deportes', 'El simulador de fútbol más avanzado con tecnología HyperMotion que mejora cada animación en tiempo real.\r\nDisfruta de partidos intensos con físicas realistas y movimientos fluidos.\r\nIncluye modos como Carrera, Ultimate Team y multijugador online competitivo.\r\nGráficos de última generación con estadios detallados y ambiente auténtico.\r\nIA mejorada que adapta la dificultad a tu estilo de juego.\r\nVive la experiencia más cercana al fútbol profesional desde casa.', 'productos/videojuegos/deporte/ea-sports-fc-26-caratula.webp', 'Xbox', NULL, NULL, 'fifa-26-xbox'),
(52, 'FIFA 26', 69.99, 24, 'Juego', 'Deportes', 'El simulador de fútbol más avanzado con tecnología HyperMotion que mejora cada animación en tiempo real.\r\nDisfruta de partidos intensos con físicas realistas y movimientos fluidos.\r\nIncluye modos como Carrera, Ultimate Team y multijugador online competitivo.\r\nGráficos de última generación con estadios detallados y ambiente auténtico.\r\nIA mejorada que adapta la dificultad a tu estilo de juego.\r\nVive la experiencia más cercana al fútbol profesional desde casa.', 'productos/videojuegos/deporte/ea-sports-fc-26-caratula.webp', 'Switch', NULL, NULL, 'fifa-26-switch'),
(53, 'NBA 2K26', 59.90, 15, 'Juego', 'Deportes', 'Experimenta la emoción del baloncesto con gráficos hiperrealistas y animaciones precisas.\r\nControla cada jugada con nuevas mecánicas ofensivas y defensivas.\r\nModo MyCareer mejorado con historia envolvente.\r\nCompite online contra jugadores de todo el mundo.\r\nAmbientes y estadios recreados con gran detalle.\r\nIdeal para los amantes del baloncesto competitivo.', 'productos/videojuegos/deporte/nba-2k-26-caratula.webp', 'PS5', NULL, NULL, 'nba-2k26-ps5'),
(54, 'NBA 2K26', 59.90, 15, 'Juego', 'Deportes', 'Experimenta la emoción del baloncesto con gráficos hiperrealistas y animaciones precisas.\r\nControla cada jugada con nuevas mecánicas ofensivas y defensivas.\r\nModo MyCareer mejorado con historia envolvente.\r\nCompite online contra jugadores de todo el mundo.\r\nAmbientes y estadios recreados con gran detalle.\r\nIdeal para los amantes del baloncesto competitivo.', 'productos/videojuegos/deporte/nba-2k-26-caratula.webp', 'Switch', NULL, NULL, 'nba-2k26-switch'),
(55, 'F1 24', 65.00, 10, 'Juego', 'Deportes', 'Siente la velocidad extrema de la Fórmula 1 con físicas realistas.\r\nCompite en circuitos oficiales con condiciones dinámicas.\r\nModo carrera profundo con gestión de equipo incluida.\r\nGráficos espectaculares que reflejan cada detalle del coche.\r\nIA desafiante que pone a prueba tus habilidades.\r\nLa experiencia definitiva de conducción profesional.', 'productos/videojuegos/deporte/f1-24-caratula.webp', 'Xbox', NULL, NULL, 'f1-24-xbox'),
(56, 'F1 24', 65.00, 10, 'Juego', 'Deportes', 'Siente la velocidad extrema de la Fórmula 1 con físicas realistas.\r\nCompite en circuitos oficiales con condiciones dinámicas.\r\nModo carrera profundo con gestión de equipo incluida.\r\nGráficos espectaculares que reflejan cada detalle del coche.\r\nIA desafiante que pone a prueba tus habilidades.\r\nLa experiencia definitiva de conducción profesional.', 'productos/videojuegos/deporte/f1-24-caratula.webp', 'Switch', NULL, NULL, 'f1-24-switch'),
(57, 'Gran Turismo 7', 69.99, 20, 'Juego', 'Deportes', 'El simulador de conducción más completo con vehículos reales licenciados.\r\nDisfruta de cientos de coches y circuitos detallados.\r\nFísicas avanzadas que recrean la conducción real.\r\nModo campaña y competiciones online.\r\nGráficos impresionantes con tecnología ray tracing.\r\nPerfecto para fans del motor y la velocidad.', 'productos/videojuegos/deporte/gran-turismo-7-caratula.webp', 'Xbox', NULL, NULL, 'gran-turismo-7-xbox'),
(58, 'Gran Turismo 7', 69.99, 20, 'Juego', 'Deportes', 'El simulador de conducción más completo con vehículos reales licenciados.\r\nDisfruta de cientos de coches y circuitos detallados.\r\nFísicas avanzadas que recrean la conducción real.\r\nModo campaña y competiciones online.\r\nGráficos impresionantes con tecnología ray tracing.\r\nPerfecto para fans del motor y la velocidad.', 'productos/videojuegos/deporte/gran-turismo-7-caratula.webp', 'Switch', NULL, NULL, 'gran-turismo-7-switch'),
(59, 'Forza Horizon 5', 59.99, 30, 'Juego', 'Deportes', 'Explora un mundo abierto lleno de carreras y desafíos en México.\r\nGran variedad de vehículos y personalización avanzada.\r\nEventos dinámicos y clima cambiante.\r\nModo online con amigos y competiciones.\r\nGráficos vibrantes y detallados.\r\nDiversión asegurada en cada carrera.', 'productos/videojuegos/deporte/forza-horizon-5-caratula.webp', 'PS5', NULL, NULL, 'forza-horizon-5-ps5'),
(61, 'Mario Strikers: Battle League', 49.99, 12, 'Juego', 'Deportes', 'Fútbol arcade lleno de acción con personajes de Nintendo.\r\nPartidos caóticos con habilidades especiales.\r\nMultijugador local y online.\r\nEstilo visual colorido y dinámico.\r\nJugabilidad rápida y divertida.\r\nPerfecto para jugar con amigos.', 'productos/videojuegos/deporte/Mario-Strikers-caratula.webp', 'PS5', NULL, NULL, 'mario-strikers-battle-league-ps5'),
(62, 'Mario Strikers: Battle League', 49.99, 12, 'Juego', 'Deportes', 'Fútbol arcade lleno de acción con personajes de Nintendo.\r\nPartidos caóticos con habilidades especiales.\r\nMultijugador local y online.\r\nEstilo visual colorido y dinámico.\r\nJugabilidad rápida y divertida.\r\nPerfecto para jugar con amigos.', 'productos/videojuegos/deporte/Mario-Strikers-caratula.webp', 'Xbox', NULL, NULL, 'mario-strikers-battle-league-xbox'),
(63, 'WWE 2K24', 55.00, 8, 'Juego', 'Deportes', 'Vive la emoción de la lucha libre con gráficos realistas.\r\nGran variedad de luchadores y modos de juego.\r\nCrea tu propio personaje y carrera.\r\nAnimaciones mejoradas y combates fluidos.\r\nModo online competitivo.\r\nIdeal para fans del wrestling.', 'productos/videojuegos/deporte/www-2k-24-caratula.webp', 'Xbox', NULL, NULL, 'wwe-2k24-xbox'),
(64, 'WWE 2K24', 55.00, 8, 'Juego', 'Deportes', 'Vive la emoción de la lucha libre con gráficos realistas.\r\nGran variedad de luchadores y modos de juego.\r\nCrea tu propio personaje y carrera.\r\nAnimaciones mejoradas y combates fluidos.\r\nModo online competitivo.\r\nIdeal para fans del wrestling.', 'productos/videojuegos/deporte/www-2k-24-caratula.webp', 'Switch', NULL, NULL, 'wwe-2k24-switch'),
(65, 'Madden NFL 26', 60.00, 10, 'Juego', 'Deportes', 'Simulación completa de fútbol americano con jugadas estratégicas.\r\nControl total del equipo y gestión táctica.\r\nModos online y offline.\r\nGráficos realistas con estadios auténticos.\r\nIA avanzada para mayor desafío.\r\nPerfecto para fans de la NFL.', 'productos/videojuegos/deporte/madden-nfl-26-caratula.webp', 'PS5', NULL, NULL, 'madden-nfl-26-ps5'),
(66, 'Madden NFL 26', 60.00, 9, 'Juego', 'Deportes', 'Simulación completa de fútbol americano con jugadas estratégicas.\r\nControl total del equipo y gestión táctica.\r\nModos online y offline.\r\nGráficos realistas con estadios auténticos.\r\nIA avanzada para mayor desafío.\r\nPerfecto para fans de la NFL.', 'productos/videojuegos/deporte/madden-nfl-26-caratula.webp', 'Switch', NULL, NULL, 'madden-nfl-26-switch'),
(67, 'Tony Hawks Pro Skater 1+2', 39.99, 5, 'Juego', 'Deportes', 'Remasterización de los clásicos juegos de skate más icónicos.\r\nTrucos fluidos y jugabilidad mejorada.\r\nMapas originales con gráficos modernos.\r\nModo multijugador online.\r\nGran banda sonora.\r\nDiversión arcade asegurada.', 'productos/videojuegos/deporte/tony-hawks-pro-skater-1mas2.webp', 'PS5', NULL, NULL, 'tony-hawks-pro-skater-1-2-ps5'),
(68, 'Tony Hawks Pro Skater 1+2', 39.99, 5, 'Juego', 'Deportes', 'Remasterización de los clásicos juegos de skate más icónicos.\r\nTrucos fluidos y jugabilidad mejorada.\r\nMapas originales con gráficos modernos.\r\nModo multijugador online.\r\nGran banda sonora.\r\nDiversión arcade asegurada.', 'productos/videojuegos/deporte/tony-hawks-pro-skater-1mas2.webp', 'Switch', NULL, NULL, 'tony-hawks-pro-skater-1-2-switch'),
(69, 'Rocket League Ultimate', 29.99, 100, 'Juego', 'Deportes', 'Fútbol con coches a toda velocidad en partidos caóticos.\r\nMecánicas simples pero altamente competitivas.\r\nMultijugador online muy activo.\r\nPersonalización de vehículos.\r\nPartidas rápidas y adictivas.\r\nIdeal para jugar con amigos.', 'productos/videojuegos/deporte/rocket-league-ultimate-caratula.webp', 'PS5', NULL, NULL, 'rocket-league-ultimate-ps5'),
(70, 'Rocket League Ultimate', 29.99, 100, 'Juego', 'Deportes', 'Fútbol con coches a toda velocidad en partidos caóticos.\r\nMecánicas simples pero altamente competitivas.\r\nMultijugador online muy activo.\r\nPersonalización de vehículos.\r\nPartidas rápidas y adictivas.\r\nIdeal para jugar con amigos.', 'productos/videojuegos/deporte/rocket-league-ultimate-caratula.webp', 'Xbox', NULL, NULL, 'rocket-league-ultimate-xbox'),
(71, 'Call of Duty: Black Ops 6', 79.99, 50, 'Juego', 'Acción', 'Sumérgete en combates intensos en primera persona con una narrativa cinematográfica.\r\nCampaña llena de acción con misiones dinámicas y momentos épicos.\r\nModo multijugador competitivo con mapas variados.\r\nArmas personalizables y progresión avanzada.\r\nGráficos realistas con efectos visuales de última generación.\r\nUna experiencia imprescindible para amantes de los shooters.', 'productos/videojuegos/accion/cod-bo6-caratula.webp', 'Xbox', NULL, NULL, 'call-of-duty-black-ops-6-xbox'),
(72, 'Call of Duty: Black Ops 6', 79.99, 50, 'Juego', 'Acción', 'Sumérgete en combates intensos en primera persona con una narrativa cinematográfica.\r\nCampaña llena de acción con misiones dinámicas y momentos épicos.\r\nModo multijugador competitivo con mapas variados.\r\nArmas personalizables y progresión avanzada.\r\nGráficos realistas con efectos visuales de última generación.\r\nUna experiencia imprescindible para amantes de los shooters.', 'productos/videojuegos/accion/cod-bo6-caratula.webp', 'Switch', NULL, NULL, 'call-of-duty-black-ops-6-switch'),
(73, 'Doom Eternal', 29.99, 15, 'Juego', 'Acción', 'Acción frenética contra hordas de demonios en escenarios infernales.\r\nMovimiento rápido y combate agresivo que recompensa la habilidad.\r\nGran variedad de armas devastadoras.\r\nBanda sonora intensa que acompaña cada batalla.\r\nDiseño de niveles vertical y dinámico.\r\nUna experiencia pura de adrenalina sin pausas.', 'productos/videojuegos/accion/doom-eternal-caratula.webp', 'PS5', NULL, NULL, 'doom-eternal-ps5'),
(74, 'Doom Eternal', 29.99, 15, 'Juego', 'Acción', 'Acción frenética contra hordas de demonios en escenarios infernales.\r\nMovimiento rápido y combate agresivo que recompensa la habilidad.\r\nGran variedad de armas devastadoras.\r\nBanda sonora intensa que acompaña cada batalla.\r\nDiseño de niveles vertical y dinámico.\r\nUna experiencia pura de adrenalina sin pausas.', 'productos/videojuegos/accion/doom-eternal-caratula.webp', 'Switch', NULL, NULL, 'doom-eternal-switch'),
(75, 'Halo Infinite', 39.99, 20, 'Juego', 'Acción', 'La legendaria saga regresa con mundo abierto y libertad total.\r\nExplora un entorno amplio lleno de misiones y secretos.\r\nCombate táctico con armas futuristas.\r\nModo multijugador competitivo y cooperativo.\r\nGráficos espectaculares y narrativa envolvente.\r\nUna aventura imprescindible para fans de la saga.', 'productos/videojuegos/accion/halo-infinite-caratula.webp', 'PS5', NULL, NULL, 'halo-infinite-ps5'),
(76, 'Halo Infinite', 39.99, 20, 'Juego', 'Acción', 'La legendaria saga regresa con mundo abierto y libertad total.\r\nExplora un entorno amplio lleno de misiones y secretos.\r\nCombate táctico con armas futuristas.\r\nModo multijugador competitivo y cooperativo.\r\nGráficos espectaculares y narrativa envolvente.\r\nUna aventura imprescindible para fans de la saga.', 'productos/videojuegos/accion/halo-infinite-caratula.webp', 'Switch', NULL, NULL, 'halo-infinite-switch'),
(77, 'Devil May Cry 5', 25.00, 10, 'Juego', 'Acción', 'Hack and slash de alta velocidad con estilo espectacular.\r\nCombates fluidos con combos impresionantes.\r\nPersonajes carismáticos y narrativa intensa.\r\nGran variedad de armas y habilidades.\r\nGráficos estilizados con efectos llamativos.\r\nAcción pura con un ritmo frenético.', 'productos/videojuegos/accion/devil-may-cry-6-caratula.webp', 'Xbox', NULL, NULL, 'devil-may-cry-5-xbox'),
(78, 'Devil May Cry 5', 25.00, 10, 'Juego', 'Acción', 'Hack and slash de alta velocidad con estilo espectacular.\r\nCombates fluidos con combos impresionantes.\r\nPersonajes carismáticos y narrativa intensa.\r\nGran variedad de armas y habilidades.\r\nGráficos estilizados con efectos llamativos.\r\nAcción pura con un ritmo frenético.', 'productos/videojuegos/accion/devil-may-cry-6-caratula.webp', 'Switch', NULL, NULL, 'devil-may-cry-5-switch'),
(79, 'Sekiro: Shadows Die Twice', 59.99, 12, 'Juego', 'Acción', 'Viaje desafiante en el Japón feudal lleno de enemigos letales.\r\nSistema de combate preciso basado en reflejos.\r\nExploración de escenarios detallados.\r\nHistoria profunda de honor y venganza.\r\nGran dificultad que recompensa la habilidad.\r\nUna experiencia intensa y satisfactoria.', 'productos/videojuegos/accion/sekiro-shadows-die-twice-caratula.webp', 'PS5', NULL, NULL, 'sekiro-shadows-die-twice-ps5'),
(80, 'Sekiro: Shadows Die Twice', 59.99, 12, 'Juego', 'Acción', 'Viaje desafiante en el Japón feudal lleno de enemigos letales.\r\nSistema de combate preciso basado en reflejos.\r\nExploración de escenarios detallados.\r\nHistoria profunda de honor y venganza.\r\nGran dificultad que recompensa la habilidad.\r\nUna experiencia intensa y satisfactoria.', 'productos/videojuegos/accion/sekiro-shadows-die-twice-caratula.webp', 'Switch', NULL, NULL, 'sekiro-shadows-die-twice-switch'),
(81, 'Bayonetta 3', 49.99, 8, 'Juego', 'Acción', 'Acción espectacular con combates llenos de magia y estilo.\r\nEnfréntate a enemigos gigantescos en batallas épicas.\r\nSistema de combate fluido y dinámico.\r\nEscenarios variados y llenos de detalles.\r\nPersonaje carismático con gran personalidad.\r\nUna experiencia única dentro del género.', 'productos/videojuegos/accion/bayonetta-3-caratula.webp', 'PS5', NULL, NULL, 'bayonetta-3-ps5'),
(82, 'Bayonetta 3', 49.99, 8, 'Juego', 'Acción', 'Acción espectacular con combates llenos de magia y estilo.\r\nEnfréntate a enemigos gigantescos en batallas épicas.\r\nSistema de combate fluido y dinámico.\r\nEscenarios variados y llenos de detalles.\r\nPersonaje carismático con gran personalidad.\r\nUna experiencia única dentro del género.', 'productos/videojuegos/accion/bayonetta-3-caratula.webp', 'Xbox', NULL, NULL, 'bayonetta-3-xbox'),
(83, 'Sifu', 34.99, 15, 'Juego', 'Acción', 'Domina el Kung Fu en una historia de venganza intensa.\r\nSistema de combate técnico y desafiante.\r\nMecánica de envejecimiento única.\r\nDiseño artístico minimalista y elegante.\r\nNiveles diseñados para rejugabilidad.\r\nIdeal para jugadores que buscan reto.', 'productos/videojuegos/accion/sifu-caratula.webp', 'Xbox', NULL, NULL, 'sifu-xbox'),
(84, 'Sifu', 34.99, 15, 'Juego', 'Acción', 'Domina el Kung Fu en una historia de venganza intensa.\r\nSistema de combate técnico y desafiante.\r\nMecánica de envejecimiento única.\r\nDiseño artístico minimalista y elegante.\r\nNiveles diseñados para rejugabilidad.\r\nIdeal para jugadores que buscan reto.', 'productos/videojuegos/accion/sifu-caratula.webp', 'Switch', NULL, NULL, 'sifu-switch'),
(85, 'Wolfenstein II', 19.99, 20, 'Juego', 'Acción', 'Shooter ambientado en una realidad alternativa dominada por enemigos.\r\nHistoria intensa con narrativa profunda.\r\nArmas variadas y combates estratégicos.\r\nEscenarios detallados y ambientación inmersiva.\r\nAcción constante y ritmo dinámico.\r\nUn clásico moderno del género.', 'productos/videojuegos/accion/wolfensteinII-caratula.webp', 'PS5', NULL, NULL, 'wolfenstein-ii-ps5'),
(86, 'Wolfenstein II', 19.99, 20, 'Juego', 'Acción', 'Shooter ambientado en una realidad alternativa dominada por enemigos.\r\nHistoria intensa con narrativa profunda.\r\nArmas variadas y combates estratégicos.\r\nEscenarios detallados y ambientación inmersiva.\r\nAcción constante y ritmo dinámico.\r\nUn clásico moderno del género.', 'productos/videojuegos/accion/wolfensteinII-caratula.webp', 'Switch', NULL, NULL, 'wolfenstein-ii-switch'),
(87, 'Astral Chain', 45.00, 5, 'Juego', 'Acción', 'Combate futurista combinando acción y estrategia.\r\nControla personajes y entidades al mismo tiempo.\r\nHistoria envolvente con estilo anime.\r\nEscenarios urbanos detallados.\r\nSistema de combate innovador.\r\nExclusivo con una experiencia única.', 'productos/videojuegos/accion/astral-chain-caratula.webp', 'PS5', NULL, NULL, 'astral-chain-ps5'),
(88, 'Astral Chain', 45.00, 5, 'Juego', 'Acción', 'Combate futurista combinando acción y estrategia.\r\nControla personajes y entidades al mismo tiempo.\r\nHistoria envolvente con estilo anime.\r\nEscenarios urbanos detallados.\r\nSistema de combate innovador.\r\nExclusivo con una experiencia única.', 'productos/videojuegos/accion/astral-chain-caratula.webp', 'Xbox', NULL, NULL, 'astral-chain-xbox'),
(89, 'Hades', 24.99, 40, 'Juego', 'Acción', 'Roguelike de acción con combates rápidos y adictivos.\r\nHistoria basada en la mitología griega.\r\nGran variedad de armas y habilidades.\r\nDiseño artístico impresionante.\r\nAlta rejugabilidad en cada partida.\r\nUna joya imprescindible del género indie.', 'productos/videojuegos/accion/hades-caratula.webp', 'PS5', NULL, NULL, 'hades-ps5'),
(90, 'Hades', 24.99, 40, 'Juego', 'Acción', 'Roguelike de acción con combates rápidos y adictivos.\r\nHistoria basada en la mitología griega.\r\nGran variedad de armas y habilidades.\r\nDiseño artístico impresionante.\r\nAlta rejugabilidad en cada partida.\r\nUna joya imprescindible del género indie.', 'productos/videojuegos/accion/hades-caratula.webp', 'Xbox', NULL, NULL, 'hades-xbox'),
(91, 'The Legend of Zelda: TotK', 69.99, 30, 'Juego', 'Aventura', 'Embárcate en una aventura épica en un mundo abierto lleno de misterios.\r\nExplora cielos y tierras con total libertad.\r\nResuelve puzles y enfréntate a enemigos desafiantes.\r\nHistoria profunda con personajes memorables.\r\nGráficos artísticos y detallados.\r\nUna experiencia imprescindible para amantes de la aventura.', 'productos/videojuegos/aventura/zelda-tears-of-the-kingdom-caratula.webp', 'PS5', NULL, NULL, 'the-legend-of-zelda-totk-ps5'),
(92, 'The Legend of Zelda: TotK', 69.99, 30, 'Juego', 'Aventura', 'Embárcate en una aventura épica en un mundo abierto lleno de misterios.\r\nExplora cielos y tierras con total libertad.\r\nResuelve puzles y enfréntate a enemigos desafiantes.\r\nHistoria profunda con personajes memorables.\r\nGráficos artísticos y detallados.\r\nUna experiencia imprescindible para amantes de la aventura.', 'productos/videojuegos/aventura/zelda-tears-of-the-kingdom-caratula.webp', 'Xbox', NULL, NULL, 'the-legend-of-zelda-totk-xbox'),
(93, 'Uncharted: Legacy of Thieves', 49.99, 20, 'Juego', 'Aventura', 'Viaja por el mundo en busca de tesoros perdidos y secretos antiguos.\r\nAventura cinematográfica con acción constante.\r\nEscenarios espectaculares y detallados.\r\nPersonajes carismáticos y narrativa envolvente.\r\nCombina exploración, plataformas y combate.\r\nUna experiencia digna de una película de acción.', 'productos/videojuegos/aventura/uncharted-legacy-of-thieves-caratula.webp', 'Xbox', NULL, NULL, 'uncharted-legacy-of-thieves-xbox'),
(94, 'Uncharted: Legacy of Thieves', 49.99, 20, 'Juego', 'Aventura', 'Viaja por el mundo en busca de tesoros perdidos y secretos antiguos.\r\nAventura cinematográfica con acción constante.\r\nEscenarios espectaculares y detallados.\r\nPersonajes carismáticos y narrativa envolvente.\r\nCombina exploración, plataformas y combate.\r\nUna experiencia digna de una película de acción.', 'productos/videojuegos/aventura/uncharted-legacy-of-thieves-caratula.webp', 'Switch', NULL, NULL, 'uncharted-legacy-of-thieves-switch'),
(95, 'God of War Ragnarok', 59.99, 25, 'Juego', 'Aventura', 'Vive la épica historia de Kratos y Atreus en su viaje final.\r\nCombates intensos con enemigos mitológicos.\r\nNarrativa profunda cargada de emociones.\r\nEscenarios impresionantes inspirados en la mitología nórdica.\r\nSistema de progresión y habilidades mejorado.\r\nUna obra maestra de la aventura moderna.', 'productos/videojuegos/aventura/god-of-war-ragnarok-caratula.webp', 'Xbox', NULL, NULL, 'god-of-war-ragnarok-xbox'),
(96, 'God of War Ragnarok', 59.99, 25, 'Juego', 'Aventura', 'Vive la épica historia de Kratos y Atreus en su viaje final.\r\nCombates intensos con enemigos mitológicos.\r\nNarrativa profunda cargada de emociones.\r\nEscenarios impresionantes inspirados en la mitología nórdica.\r\nSistema de progresión y habilidades mejorado.\r\nUna obra maestra de la aventura moderna.', 'productos/videojuegos/aventura/god-of-war-ragnarok-caratula.webp', 'Switch', NULL, NULL, 'god-of-war-ragnarok-switch'),
(97, 'Horizon Forbidden West', 49.99, 15, 'Juego', 'Aventura', 'Explora un mundo postapocalíptico dominado por máquinas.\r\nCaza criaturas robóticas con armas avanzadas.\r\nHistoria rica y llena de misterio.\r\nEntornos abiertos llenos de vida y detalle.\r\nSistema de combate estratégico.\r\nUna aventura visualmente espectacular.', 'productos/videojuegos/aventura/horizon-forbidden-caratula.webp', 'Xbox', NULL, NULL, 'horizon-forbidden-west-xbox'),
(98, 'Horizon Forbidden West', 49.99, 15, 'Juego', 'Aventura', 'Explora un mundo postapocalíptico dominado por máquinas.\r\nCaza criaturas robóticas con armas avanzadas.\r\nHistoria rica y llena de misterio.\r\nEntornos abiertos llenos de vida y detalle.\r\nSistema de combate estratégico.\r\nUna aventura visualmente espectacular.', 'productos/videojuegos/aventura/horizon-forbidden-caratula.webp', 'Switch', NULL, NULL, 'horizon-forbidden-west-switch'),
(99, 'Ghost of Tsushima', 39.99, 10, 'Juego', 'Aventura', 'Conviértete en un samurái en la isla de Tsushima.\r\nCombate con espada en duelos intensos.\r\nExplora paisajes hermosos inspirados en Japón.\r\nHistoria de honor, sacrificio y venganza.\r\nEstilo visual cinematográfico.\r\nUna experiencia inmersiva única.', 'productos/videojuegos/aventura/ghost-of-tsushima-caratula.webp', 'Xbox', NULL, NULL, 'ghost-of-tsushima-xbox'),
(100, 'Ghost of Tsushima', 39.99, 10, 'Juego', 'Aventura', 'Conviértete en un samurái en la isla de Tsushima.\r\nCombate con espada en duelos intensos.\r\nExplora paisajes hermosos inspirados en Japón.\r\nHistoria de honor, sacrificio y venganza.\r\nEstilo visual cinematográfico.\r\nUna experiencia inmersiva única.', 'productos/videojuegos/aventura/ghost-of-tsushima-caratula.webp', 'Switch', NULL, NULL, 'ghost-of-tsushima-switch'),
(101, 'Sea of Thieves', 39.99, 25, 'Juego', 'Aventura', 'Vive la vida pirata en un mundo abierto multijugador.\r\nNavega, lucha y busca tesoros con tu tripulación.\r\nEventos dinámicos en alta mar.\r\nGran libertad de exploración.\r\nEstilo visual colorido y divertido.\r\nPerfecto para jugar con amigos.', 'productos/videojuegos/aventura/sea-of-thieves-caratula.webp', 'PS5', NULL, NULL, 'sea-of-thieves-ps5'),
(102, 'Sea of Thieves', 39.99, 25, 'Juego', 'Aventura', 'Vive la vida pirata en un mundo abierto multijugador.\r\nNavega, lucha y busca tesoros con tu tripulación.\r\nEventos dinámicos en alta mar.\r\nGran libertad de exploración.\r\nEstilo visual colorido y divertido.\r\nPerfecto para jugar con amigos.', 'productos/videojuegos/aventura/sea-of-thieves-caratula.webp', 'Switch', NULL, NULL, 'sea-of-thieves-switch'),
(103, 'Prince of Persia: The Lost Crown', 45.00, 12, 'Juego', 'Aventura', 'Acción y plataformas en una aventura ambientada en Persia.\r\nCombate ágil con habilidades especiales.\r\nExplora escenarios en 2.5D llenos de secretos.\r\nHistoria inspirada en la mitología.\r\nDiseño artístico llamativo.\r\nUna mezcla perfecta de acción y exploración.', 'productos/videojuegos/aventura/prince-of-persia-the-lost-crown-caratula.webp', 'PS5', NULL, NULL, 'prince-of-persia-the-lost-crown-ps5'),
(104, 'Prince of Persia: The Lost Crown', 45.00, 12, 'Juego', 'Aventura', 'Acción y plataformas en una aventura ambientada en Persia.\r\nCombate ágil con habilidades especiales.\r\nExplora escenarios en 2.5D llenos de secretos.\r\nHistoria inspirada en la mitología.\r\nDiseño artístico llamativo.\r\nUna mezcla perfecta de acción y exploración.', 'productos/videojuegos/aventura/prince-of-persia-the-lost-crown-caratula.webp', 'Xbox', NULL, NULL, 'prince-of-persia-the-lost-crown-xbox'),
(105, 'Assassins Creed Valhalla', 35.00, 20, 'Juego', 'Aventura', 'Conquista Inglaterra como un feroz guerrero vikingo.\r\nExplora un mundo abierto lleno de misiones.\r\nCombate brutal con armas y habilidades.\r\nConstruye y gestiona tu asentamiento.\r\nNarrativa épica basada en la historia.\r\nUna aventura extensa y envolvente.', 'productos/videojuegos/aventura/assassin-creed-valhalla.webp', 'PS5', NULL, NULL, 'assassins-creed-valhalla-ps5'),
(106, 'Assassins Creed Valhalla', 35.00, 20, 'Juego', 'Aventura', 'Conquista Inglaterra como un feroz guerrero vikingo.\r\nExplora un mundo abierto lleno de misiones.\r\nCombate brutal con armas y habilidades.\r\nConstruye y gestiona tu asentamiento.\r\nNarrativa épica basada en la historia.\r\nUna aventura extensa y envolvente.', 'productos/videojuegos/aventura/assassin-creed-valhalla.webp', 'Switch', NULL, NULL, 'assassins-creed-valhalla-switch'),
(107, 'Ratchet & Clank', 59.99, 15, 'Juego', 'Aventura', 'Salta entre dimensiones en una aventura llena de acción.\r\nArmas creativas y combate dinámico.\r\nEscenarios futuristas con gran detalle.\r\nHistoria divertida y personajes carismáticos.\r\nGráficos de nueva generación.\r\nUna experiencia espectacular y entretenida.', 'productos/videojuegos/aventura/ratchet-and-clank-caratula.webp', 'Xbox', NULL, NULL, 'ratchet-y-clank-xbox'),
(108, 'Ratchet & Clank', 59.99, 15, 'Juego', 'Aventura', 'Salta entre dimensiones en una aventura llena de acción.\r\nArmas creativas y combate dinámico.\r\nEscenarios futuristas con gran detalle.\r\nHistoria divertida y personajes carismáticos.\r\nGráficos de nueva generación.\r\nUna experiencia espectacular y entretenida.', 'productos/videojuegos/aventura/ratchet-and-clank-caratula.webp', 'Switch', NULL, NULL, 'ratchet-y-clank-switch'),
(109, 'Super Mario Odyssey', 49.99, 10, 'Juego', 'Aventura', 'Acompaña a Mario en un viaje por mundos increíbles.\r\nExplora escenarios llenos de secretos.\r\nMecánicas innovadoras con Cappy.\r\nDiseño creativo y variado.\r\nJugabilidad accesible y divertida.\r\nUn clásico moderno de plataformas en 3D.', 'productos/videojuegos/aventura/super-mario-odyssey-caratula.webp', 'PS5', NULL, NULL, 'super-mario-odyssey-ps5'),
(110, 'Super Mario Odyssey', 49.99, 10, 'Juego', 'Aventura', 'Acompaña a Mario en un viaje por mundos increíbles.\r\nExplora escenarios llenos de secretos.\r\nMecánicas innovadoras con Cappy.\r\nDiseño creativo y variado.\r\nJugabilidad accesible y divertida.\r\nUn clásico moderno de plataformas en 3D.', 'productos/videojuegos/aventura/super-mario-odyssey-caratula.webp', 'Xbox', NULL, NULL, 'super-mario-odyssey-xbox'),
(111, 'Resident Evil Village', 39.99, 18, 'Juego', 'Terror', 'Sobrevive a una pesadilla en un pueblo lleno de criaturas aterradoras.\r\nAmbiente oscuro con tensión constante.\r\nCombate y gestión de recursos limitados.\r\nHistoria inquietante llena de misterios.\r\nGráficos realistas que aumentan la inmersión.\r\nUna experiencia de horror intensa e inolvidable.', 'productos/videojuegos/terror/resident-evil-8-caratula.webp', 'Xbox', NULL, NULL, 'resident-evil-village-xbox'),
(112, 'Resident Evil Village', 39.99, 18, 'Juego', 'Terror', 'Sobrevive a una pesadilla en un pueblo lleno de criaturas aterradoras.\r\nAmbiente oscuro con tensión constante.\r\nCombate y gestión de recursos limitados.\r\nHistoria inquietante llena de misterios.\r\nGráficos realistas que aumentan la inmersión.\r\nUna experiencia de horror intensa e inolvidable.', 'productos/videojuegos/terror/resident-evil-8-caratula.webp', 'Switch', NULL, NULL, 'resident-evil-village-switch');
INSERT INTO `productos` (`id_producto`, `nombre`, `precio`, `stock`, `tipo`, `categoria`, `descripcion`, `img_url`, `plataforma`, `tieneLector`, `almacenamiento`, `slug`) VALUES
(113, 'Silent Hill 2 Remake', 69.99, 12, 'Juego', 'Terror', 'Sumérgete en una historia de terror psicológico profundamente perturbadora.\r\nExplora una ciudad envuelta en niebla y secretos.\r\nNarrativa intensa cargada de simbolismo.\r\nAmbiente opresivo que genera tensión constante.\r\nSonido y diseño que potencian el miedo.\r\nUna obra maestra del terror moderno.', 'productos/videojuegos/terror/silent-hill-2-remake-caratula.webp', 'Xbox', NULL, NULL, 'silent-hill-2-remake-xbox'),
(114, 'Silent Hill 2 Remake', 69.99, 12, 'Juego', 'Terror', 'Sumérgete en una historia de terror psicológico profundamente perturbadora.\r\nExplora una ciudad envuelta en niebla y secretos.\r\nNarrativa intensa cargada de simbolismo.\r\nAmbiente opresivo que genera tensión constante.\r\nSonido y diseño que potencian el miedo.\r\nUna obra maestra del terror moderno.', 'productos/videojuegos/terror/silent-hill-2-remake-caratula.webp', 'Switch', NULL, NULL, 'silent-hill-2-remake-switch'),
(115, 'Dead Space Remake', 59.99, 10, 'Juego', 'Terror', 'Vive el horror espacial en una nave infestada de criaturas.\r\nAmbiente claustrofóbico y angustiante.\r\nCombate estratégico con recursos limitados.\r\nDiseño de sonido que incrementa la tensión.\r\nGráficos renovados con gran detalle.\r\nUna experiencia aterradora en el espacio.', 'productos/videojuegos/terror/dead-space-remake-caratula.webp', 'PS5', NULL, NULL, 'dead-space-remake-ps5'),
(116, 'Dead Space Remake', 59.99, 10, 'Juego', 'Terror', 'Vive el horror espacial en una nave infestada de criaturas.\r\nAmbiente claustrofóbico y angustiante.\r\nCombate estratégico con recursos limitados.\r\nDiseño de sonido que incrementa la tensión.\r\nGráficos renovados con gran detalle.\r\nUna experiencia aterradora en el espacio.', 'productos/videojuegos/terror/dead-space-remake-caratula.webp', 'Switch', NULL, NULL, 'dead-space-remake-switch'),
(117, 'Alan Wake 2', 55.00, 15, 'Juego', 'Terror', 'Un thriller psicológico que mezcla realidad y pesadilla.\r\nHistoria profunda con múltiples capas narrativas.\r\nAmbiente oscuro y sobrenatural.\r\nExploración e investigación constantes.\r\nNarrativa envolvente con giros inesperados.\r\nIdeal para amantes del terror psicológico.', 'productos/videojuegos/terror/alan-wake-2-caratula.webp', 'PS5', NULL, NULL, 'alan-wake-2-ps5'),
(118, 'Alan Wake 2', 55.00, 15, 'Juego', 'Terror', 'Un thriller psicológico que mezcla realidad y pesadilla.\r\nHistoria profunda con múltiples capas narrativas.\r\nAmbiente oscuro y sobrenatural.\r\nExploración e investigación constantes.\r\nNarrativa envolvente con giros inesperados.\r\nIdeal para amantes del terror psicológico.', 'productos/videojuegos/terror/alan-wake-2-caratula.webp', 'Switch', NULL, NULL, 'alan-wake-2-switch'),
(119, 'Little Nightmares II', 29.99, 25, 'Juego', 'Terror', 'Ayuda a Mono a sobrevivir en un mundo oscuro y distorsionado.\r\nPlataformas con puzles inquietantes.\r\nDiseño artístico único y perturbador.\r\nHistoria contada de forma visual.\r\nAmbiente opresivo y misterioso.\r\nUna experiencia corta pero impactante.', 'productos/videojuegos/terror/little-nightmaresII-caratula.webp', 'PS5', NULL, NULL, 'little-nightmares-ii-ps5'),
(120, 'Little Nightmares II', 29.99, 24, 'Juego', 'Terror', 'Ayuda a Mono a sobrevivir en un mundo oscuro y distorsionado.\r\nPlataformas con puzles inquietantes.\r\nDiseño artístico único y perturbador.\r\nHistoria contada de forma visual.\r\nAmbiente opresivo y misterioso.\r\nUna experiencia corta pero impactante.', 'productos/videojuegos/terror/little-nightmaresII-caratula.webp', 'Xbox', NULL, NULL, 'little-nightmares-ii-xbox'),
(121, 'Amnesia: The Bunker', 24.99, 20, 'Juego', 'Terror', 'Terror puro en un búnker durante la guerra.\r\nOscuridad constante con recursos limitados.\r\nSistema de supervivencia realista.\r\nEnemigos impredecibles que generan tensión.\r\nExploración lenta y estratégica.\r\nUna experiencia intensa y angustiante.', 'productos/videojuegos/terror/amnesia-the-bunker-caratula.webp', 'PS5', NULL, NULL, 'amnesia-the-bunker-ps5'),
(122, 'Amnesia: The Bunker', 24.99, 19, 'Juego', 'Terror', 'Terror puro en un búnker durante la guerra.\r\nOscuridad constante con recursos limitados.\r\nSistema de supervivencia realista.\r\nEnemigos impredecibles que generan tensión.\r\nExploración lenta y estratégica.\r\nUna experiencia intensa y angustiante.', 'productos/videojuegos/terror/amnesia-the-bunker-caratula.webp', 'Switch', NULL, NULL, 'amnesia-the-bunker-switch'),
(123, 'Alien: Isolation', 29.99, 8, 'Juego', 'Terror', 'Escapa de una criatura letal en una estación espacial.\r\nIA del enemigo impredecible.\r\nAmbiente tenso y claustrofóbico.\r\nJuego basado en sigilo y supervivencia.\r\nDiseño sonoro que eleva el miedo.\r\nUn clásico del terror moderno.', 'productos/videojuegos/terror/alien-isolation-caratula.webp', 'Xbox', NULL, NULL, 'alien-isolation-xbox'),
(124, 'Alien: Isolation', 29.99, 10, 'Juego', 'Terror', 'Escapa de una criatura letal en una estación espacial.\r\nIA del enemigo impredecible.\r\nAmbiente tenso y claustrofóbico.\r\nJuego basado en sigilo y supervivencia.\r\nDiseño sonoro que eleva el miedo.\r\nUn clásico del terror moderno.', 'productos/videojuegos/terror/alien-isolation-caratula.webp', 'Switch', NULL, NULL, 'alien-isolation-switch'),
(125, 'The Evil Within 2', 19.99, 12, 'Juego', 'Terror', 'Adéntrate en un mundo de pesadillas para salvar a tu hija.\r\nAmbiente psicológico oscuro.\r\nCombate y exploración combinados.\r\nHistoria intensa y emocional.\r\nEscenarios surrealistas y perturbadores.\r\nUna experiencia inquietante y profunda.', 'productos/videojuegos/terror/the-evil-within-2-caratula.webp', 'PS5', NULL, NULL, 'the-evil-within-2-ps5'),
(126, 'The Evil Within 2', 19.99, 11, 'Juego', 'Terror', 'Adéntrate en un mundo de pesadillas para salvar a tu hija.\r\nAmbiente psicológico oscuro.\r\nCombate y exploración combinados.\r\nHistoria intensa y emocional.\r\nEscenarios surrealistas y perturbadores.\r\nUna experiencia inquietante y profunda.', 'productos/videojuegos/terror/the-evil-within-2-caratula.webp', 'Switch', NULL, NULL, 'the-evil-within-2-switch'),
(127, 'Fatal Frame: Black Water', 39.99, 8, 'Juego', 'Terror', 'Exorciza espíritus usando una cámara especial.\r\nAmbiente japonés cargado de misterio.\r\nTerror psicológico con exploración.\r\nDiseño sonoro envolvente.\r\nHistoria oscura y atrapante.\r\nUna experiencia diferente dentro del género.', 'productos/videojuegos/terror/fatal-frame-black-water-caratula.webp', 'PS5', NULL, NULL, 'fatal-frame-black-water-ps5'),
(128, 'Fatal Frame: Black Water', 39.99, 8, 'Juego', 'Terror', 'Exorciza espíritus usando una cámara especial.\r\nAmbiente japonés cargado de misterio.\r\nTerror psicológico con exploración.\r\nDiseño sonoro envolvente.\r\nHistoria oscura y atrapante.\r\nUna experiencia diferente dentro del género.', 'productos/videojuegos/terror/fatal-frame-black-water-caratula.webp', 'Xbox', NULL, NULL, 'fatal-frame-black-water-xbox'),
(129, 'Luigis Mansion 3', 49.99, 15, 'Juego', 'Terror', 'Explora un hotel encantado lleno de fantasmas.\r\nCombina humor y terror ligero.\r\nPuzles y exploración en cada planta.\r\nPersonajes carismáticos y divertidos.\r\nDiseño visual atractivo.\r\nIdeal para todas las edades.', 'productos/videojuegos/terror/luigis-mansion-3-caratula.webp', 'PS5', NULL, NULL, 'luigis-mansion-3-ps5'),
(130, 'Luigis Mansion 3', 49.99, 15, 'Juego', 'Terror', 'Explora un hotel encantado lleno de fantasmas.\r\nCombina humor y terror ligero.\r\nPuzles y exploración en cada planta.\r\nPersonajes carismáticos y divertidos.\r\nDiseño visual atractivo.\r\nIdeal para todas las edades.', 'productos/videojuegos/terror/luigis-mansion-3-caratula.webp', 'Xbox', NULL, NULL, 'luigis-mansion-3-xbox'),
(131, 'Baldurs Gate 3', 59.99, 40, 'Juego', 'RPG', 'Sumérgete en un mundo de fantasía basado en Dungeons & Dragons.\r\nDecisiones que afectan el desarrollo de la historia.\r\nCombate táctico por turnos profundo.\r\nGran libertad para crear tu personaje.\r\nExploración llena de secretos y misiones.\r\nUna experiencia RPG completa y envolvente.', 'productos/videojuegos/rpg/baldurs-gate-3-caratula.webp', 'Xbox', NULL, NULL, 'baldurs-gate-3-xbox'),
(132, 'Baldurs Gate 3', 59.99, 40, 'Juego', 'RPG', 'Sumérgete en un mundo de fantasía basado en Dungeons & Dragons.\r\nDecisiones que afectan el desarrollo de la historia.\r\nCombate táctico por turnos profundo.\r\nGran libertad para crear tu personaje.\r\nExploración llena de secretos y misiones.\r\nUna experiencia RPG completa y envolvente.', 'productos/videojuegos/rpg/baldurs-gate-3-caratula.webp', 'Switch', NULL, NULL, 'baldurs-gate-3-switch'),
(133, 'Elden Ring', 65.00, 30, 'Juego', 'RPG', 'Explora un mundo abierto oscuro lleno de misterios.\r\nCombate desafiante con gran profundidad.\r\nDiseño de niveles interconectados.\r\nHistoria contada de forma ambiental.\r\nGran variedad de armas y habilidades.\r\nUna experiencia exigente y épica.', 'productos/videojuegos/rpg/elden-ring-caratula.webp', 'PS5', NULL, NULL, 'elden-ring-ps5'),
(134, 'Elden Ring', 65.00, 30, 'Juego', 'RPG', 'Explora un mundo abierto oscuro lleno de misterios.\r\nCombate desafiante con gran profundidad.\r\nDiseño de niveles interconectados.\r\nHistoria contada de forma ambiental.\r\nGran variedad de armas y habilidades.\r\nUna experiencia exigente y épica.', 'productos/videojuegos/rpg/elden-ring-caratula.webp', 'Switch', NULL, NULL, 'elden-ring-switch'),
(135, 'The Witcher 3', 29.99, 25, 'Juego', 'RPG', 'Embárcate en la historia del brujo Geralt de Rivia.\r\nMundo abierto lleno de misiones y decisiones.\r\nNarrativa profunda con múltiples finales.\r\nCombate dinámico con magia y espada.\r\nPersonajes memorables.\r\nUn clásico imprescindible del RPG moderno.', 'productos/videojuegos/rpg/the-witcher-3-caratula.webp', 'PS5', NULL, NULL, 'the-witcher-3-ps5'),
(136, 'The Witcher 3', 29.99, 25, 'Juego', 'RPG', 'Embárcate en la historia del brujo Geralt de Rivia.\r\nMundo abierto lleno de misiones y decisiones.\r\nNarrativa profunda con múltiples finales.\r\nCombate dinámico con magia y espada.\r\nPersonajes memorables.\r\nUn clásico imprescindible del RPG moderno.', 'productos/videojuegos/rpg/the-witcher-3-caratula.webp', 'Switch', NULL, NULL, 'the-witcher-3-switch'),
(137, 'Cyberpunk 2077', 49.99, 20, 'Juego', 'RPG', 'Adéntrate en una ciudad futurista llena de peligros.\r\nPersonaliza tu personaje con mejoras cibernéticas.\r\nHistoria compleja con múltiples caminos.\r\nCombate variado con armas y habilidades.\r\nAmbiente urbano detallado.\r\nUna experiencia inmersiva en un mundo cyberpunk.', 'productos/videojuegos/rpg/cyberpunk-2077-caratula.webp', 'Xbox', NULL, NULL, 'cyberpunk-2077-xbox'),
(138, 'Cyberpunk 2077', 49.99, 20, 'Juego', 'RPG', 'Adéntrate en una ciudad futurista llena de peligros.\r\nPersonaliza tu personaje con mejoras cibernéticas.\r\nHistoria compleja con múltiples caminos.\r\nCombate variado con armas y habilidades.\r\nAmbiente urbano detallado.\r\nUna experiencia inmersiva en un mundo cyberpunk.', 'productos/videojuegos/rpg/cyberpunk-2077-caratula.webp', 'Switch', NULL, NULL, 'cyberpunk-2077-switch'),
(139, 'Final Fantasy VII Rebirth', 69.99, 15, 'Juego', 'RPG', 'Continúa la épica historia de Cloud y sus compañeros.\r\nCombate dinámico con mezcla de acción y estrategia.\r\nEscenarios impresionantes y detallados.\r\nNarrativa emocional y profunda.\r\nPersonajes icónicos del universo Final Fantasy.\r\nUna aventura inolvidable.', 'productos/videojuegos/rpg/final-fantasy-VII-rebirth.webp', 'Xbox', NULL, NULL, 'final-fantasy-vii-rebirth-xbox'),
(140, 'Final Fantasy VII Rebirth', 69.99, 14, 'Juego', 'RPG', 'Continúa la épica historia de Cloud y sus compañeros.\r\nCombate dinámico con mezcla de acción y estrategia.\r\nEscenarios impresionantes y detallados.\r\nNarrativa emocional y profunda.\r\nPersonajes icónicos del universo Final Fantasy.\r\nUna aventura inolvidable.', 'productos/videojuegos/rpg/final-fantasy-VII-rebirth.webp', 'Switch', NULL, NULL, 'final-fantasy-vii-rebirth-switch'),
(141, 'Starfield', 69.99, 20, 'Juego', 'RPG', 'Explora el espacio en un RPG de gran escala.\r\nViaja entre planetas con total libertad.\r\nCrea tu personaje y define su historia.\r\nSistema de combate variado.\r\nGran cantidad de misiones y contenido.\r\nUna experiencia espacial única.', 'productos/videojuegos/rpg/starfield-caratula.webp', 'PS5', NULL, NULL, 'starfield-ps5'),
(142, 'Starfield', 69.99, 18, 'Juego', 'RPG', 'Explora el espacio en un RPG de gran escala.\r\nViaja entre planetas con total libertad.\r\nCrea tu personaje y define su historia.\r\nSistema de combate variado.\r\nGran cantidad de misiones y contenido.\r\nUna experiencia espacial única.', 'productos/videojuegos/rpg/starfield-caratula.webp', 'Switch', NULL, NULL, 'starfield-switch'),
(143, 'Persona 5 Royal', 45.00, 10, 'Juego', 'RPG', 'Vive la doble vida de un estudiante en Tokio.\r\nSistema de combate por turnos elegante.\r\nRelaciones sociales que afectan la historia.\r\nEstilo artístico único.\r\nNarrativa profunda y envolvente.\r\nUna joya del RPG japonés.', 'productos/videojuegos/rpg/persona5-caratula.webp', 'PS5', NULL, NULL, 'persona-5-royal-ps5'),
(144, 'Persona 5 Royal', 45.00, 8, 'Juego', 'RPG', 'Vive la doble vida de un estudiante en Tokio.\r\nSistema de combate por turnos elegante.\r\nRelaciones sociales que afectan la historia.\r\nEstilo artístico único.\r\nNarrativa profunda y envolvente.\r\nUna joya del RPG japonés.', 'productos/videojuegos/rpg/persona5-caratula.webp', 'Xbox', NULL, NULL, 'persona-5-royal-xbox'),
(145, 'Dragon Age: The Veilguard', 69.99, 15, 'Juego', 'RPG', 'Salva el mundo de Thedas de una amenaza divina.\r\nToma decisiones que cambian la historia.\r\nCombate estratégico con habilidades.\r\nExploración de un mundo rico en lore.\r\nPersonajes complejos.\r\nUna experiencia RPG épica.', 'productos/videojuegos/rpg/dragon-age-4-caratula.webp', 'PS5', NULL, NULL, 'dragon-age-the-veilguard-ps5'),
(146, 'Dragon Age: The Veilguard', 69.99, 14, 'Juego', 'RPG', 'Salva el mundo de Thedas de una amenaza divina.\r\nToma decisiones que cambian la historia.\r\nCombate estratégico con habilidades.\r\nExploración de un mundo rico en lore.\r\nPersonajes complejos.\r\nUna experiencia RPG épica.', 'productos/videojuegos/rpg/dragon-age-4-caratula.webp', 'Switch', NULL, NULL, 'dragon-age-the-veilguard-switch'),
(147, 'Skyrim: Anniversary', 39.99, 24, 'Juego', 'RPG', 'Explora un mundo lleno de dragones y magia.\r\nLibertad total para crear tu aventura.\r\nSistema de progresión abierto.\r\nGran cantidad de misiones secundarias.\r\nAmbiente inmersivo.\r\nUn clásico atemporal del RPG.', 'productos/videojuegos/rpg/skyrim-anniversary-caratula.webp', 'PS5', NULL, NULL, 'skyrim-anniversary-ps5'),
(148, 'Skyrim: Anniversary', 39.99, 23, 'Juego', 'RPG', 'Explora un mundo lleno de dragones y magia.\r\nLibertad total para crear tu aventura.\r\nSistema de progresión abierto.\r\nGran cantidad de misiones secundarias.\r\nAmbiente inmersivo.\r\nUn clásico atemporal del RPG.', 'productos/videojuegos/rpg/skyrim-anniversary-caratula.webp', 'Xbox', NULL, NULL, 'skyrim-anniversary-xbox'),
(149, 'Octopath Traveler II', 55.00, 8, 'Juego', 'RPG', 'Vive ocho historias diferentes en un mundo único.\r\nCombate por turnos estratégico.\r\nEstilo visual HD-2D espectacular.\r\nPersonajes con historias profundas.\r\nExploración rica en contenido.\r\nUna experiencia RPG diferente y memorable.', 'productos/videojuegos/rpg/octopath-travelerII-caratula.webp', 'PS5', NULL, NULL, 'octopath-traveler-ii-ps5'),
(150, 'Octopath Traveler II', 55.00, 11, 'Juego', 'RPG', 'Vive ocho historias diferentes en un mundo único.\r\nCombate por turnos estratégico.\r\nEstilo visual HD-2D espectacular.\r\nPersonajes con historias profundas.\r\nExploración rica en contenido.\r\nUna experiencia RPG diferente y memorable.', 'productos/videojuegos/rpg/octopath-travelerII-caratula.webp', 'Xbox', NULL, NULL, 'octopath-traveler-ii-xbox'),
(151, 'Nintendo Switch OLED - Edición Zelda: Tears of the Kingdom', 359.99, 4, 'Consola', 'Nintendo', 'Diseño exclusivo inspirado en la saga Zelda con pantalla OLED de 7 pulgadas.', 'productos/consolas/nintendo-switch/nintendo-switch-oled-zelda.webp', 'Switch', 1, '64GB', 'nintendo-switch-oled-edicion-zelda-tears-of-the-kingdom'),
(152, 'Nintendo Switch OLED - Modelo Blanco/Azul/Rojo', 349.90, 10, 'Consola', 'Nintendo', 'Consola Nintendo Switch modelo OLED con colores clásicos y almacenamiento de 64GB.', 'productos/consolas/nintendo-switch/nintendo-switch-oled-redbluejoycon.webp', 'Switch', 1, '64GB', 'nintendo-switch-oled-modelo-blanco-azul-rojo'),
(153, 'Nintendo Switch OLED - Edición Pokémon Escarlata y Púrpura', 659.99, 4, 'Consola', 'Nintendo', 'Edición especial con motivos de Koraidon y Miraidon en el dock y Joy-Cons.', 'productos/consolas/nintendo-switch/nintendo-switch-oled-pokemon-scarlet-and-violet.webp', 'Switch', 1, '64GB', 'nintendo-switch-oled-edicion-pokemon-escarlata-y-purpura'),
(154, 'Nintendo Switch - Pack Mario Kart 8 Deluxe', 299.00, 8, 'Consola', 'Nintendo', 'Incluye la consola estándar y el código de descarga del juego Mario Kart 8 Deluxe.', 'productos/consolas/nintendo-switch/nintendo-switch-mariokart8.webp', 'Switch', 1, '32GB', 'nintendo-switch-pack-mario-kart-8-deluxe'),
(155, 'Nintendo Switch - Edición Super Mario Bros. Wonder', 310.00, 6, 'Consola', 'Nintendo', 'Pack especial que incluye la consola y el juego Super Mario Bros. Wonder.', 'productos/consolas/nintendo-switch/nintendo-switch-supermariobros-wonder.webp', 'Switch', 1, '32GB', 'nintendo-switch-edicion-super-mario-bros-wonder'),
(156, 'Nintendo Switch - Edición Nintendo Switch Sports', 295.00, 12, 'Consola', 'Nintendo', 'Consola estándar con el juego Nintendo Switch Sports preinstalado y cinta de pierna.', 'productos/consolas/nintendo-switch/nintendo-swicth-nssports.webp', 'Switch', 1, '32GB', 'nintendo-switch-edicion-nintendo-switch-sports'),
(157, 'Nintendo Switch - Edición Especial Fortnite', 320.00, 3, 'Consola', 'Nintendo', 'Diseño único de Fortnite con Joy-Cons exclusivos y moneda virtual incluida.', 'productos/consolas/nintendo-switch/nintendo-switch-fortnite.webp', 'Switch', 1, '32GB', 'nintendo-switch-edicion-especial-fortnite'),
(158, 'Nintendo Switch - Edición Monster Hunter Rise', 330.00, 2, 'Consola', 'Nintendo', 'Consola con arte serigrafiado de Magnamalo y contenido digital del juego.', 'productos/consolas/nintendo-switch/nintendo-switch-moster-hunter-rise.webp', 'Switch', 1, '32GB', 'nintendo-switch-edicion-monster-hunter-rise'),
(159, 'Nintendo Switch - Edición Splatoon 3', 345.00, 5, 'Consola', 'Nintendo', 'Colores degradados neón y motivos de Splatoon en toda la consola y base.', 'productos/consolas/nintendo-switch/nintendo-switch-splatoon3.webp', 'Switch', 1, '32GB', 'nintendo-switch-edicion-splatoon-3'),
(160, 'Nintendo Switch - Modelo Gris Estándar', 289.00, 15, 'Consola', 'Nintendo', 'Versión clásica de la consola con Joy-Cons en color gris espacial.', 'productos/consolas/nintendo-switch/nintendo-switch-gris.webp', 'Switch', 1, '32GB', 'nintendo-switch-modelo-gris-estandar'),
(161, 'Nintendo Switch OLED Blanca - Pack Mario Kart 8 Deluxe', 549.99, 8, 'Consola', 'Nintendo', 'Modelo OLED en color blanco con el juego Mario Kart 8 Deluxe incluido.', 'productos/consolas/nintendo-switch/nintendo-switch-oled-blanca-mariokart8.webp', 'Switch', 1, '64GB', 'nintendo-switch-oled-blanca-pack-mario-kart-8-deluxe'),
(162, 'Nintendo Switch - Pack Super Smash Bros. Ultimate', 599.99, 3, 'Consola', 'Nintendo', 'Consola Nintendo Switch con código de descarga para Super Smash Bros. Ultimate.', 'productos/consolas/nintendo-switch/nintendo-super-smash-bros.webp', 'Switch', 1, '32GB', 'nintendo-switch-pack-super-smash-bros-ultimate'),
(163, 'PlayStation 5 con Lector de Discos', 549.99, 9, 'Consola', 'Sony', 'Consola PS5 original con unidad de disco Blu-ray Ultra HD.', 'productos/consolas/ps5/ps5-con-disco.webp', 'PS5', 1, '825GB', 'playstation-5-con-lector-de-discos'),
(164, 'PlayStation 5 Digital Edition', 449.99, 12, 'Consola', 'Sony', 'Versión totalmente digital de la consola PS5 sin lector de discos.', 'productos/consolas/ps5/ps5-digital.webp', 'PS5', 0, '825GB', 'playstation-5-digital-edition'),
(165, 'PlayStation 5 Slim con Lector de Discos', 549.99, 15, 'Consola', 'Sony', 'Nuevo diseño Slim más ligero y compacto con lector de discos extraíble.', 'productos/consolas/ps5/ps5-slim-con-disco.webp', 'PS5', 1, '825GB', 'playstation-5-slim-con-lector-de-discos'),
(166, 'PlayStation 5 Slim Digital Edition', 449.99, 10, 'Consola', 'Sony', 'Diseño Slim ultra compacto sin lector de discos.', 'productos/consolas/ps5/ps5-slim-digital.webp', 'PS5', 0, '1TB', 'playstation-5-slim-digital-edition'),
(167, 'PlayStation 5 - Pack Horizon Forbidden West', 599.99, 4, 'Consola', 'Sony', 'Consola PS5 con lector de discos y código para el juego Horizon Forbidden West.', 'productos/consolas/ps5/ps5-horizon-con-disco.webp', 'PS5', 1, '825GB', 'playstation-5-pack-horizon-forbidden-west'),
(168, 'PlayStation 5 Slim - Pack Astro Bot', 599.99, 6, 'Consola', 'Sony', 'Consola PS5 Slim con lector de discos y la nueva aventura de Astro Bot.', 'productos/consolas/ps5/ps5-slim-con-disco-astrobot.webp', 'PS5', 1, '825GB', 'playstation-5-slim-pack-astro-bot'),
(169, 'PlayStation 5 - Pack Ghost of Yotei', 609.99, 3, 'Consola', 'Sony', 'Consola PS5 con lector de discos y reserva/código para Ghost of Yotei.', 'productos/consolas/ps5/ps5-con-disco-ghostofyotei.webp', 'PS5', 1, '825GB', 'playstation-5-pack-ghost-of-yotei'),
(170, 'PlayStation 5 - Suscripción PlayStation Premium', 151.99, 100, 'Consola', 'Sony', 'Tarjeta de suscripción anual para el servicio PlayStation Plus Premium.', 'productos/consolas/ps5/ps5-pspremium.webp', 'PS5', 1, '825GB', 'playstation-5-suscripcion-playstation-premium'),
(171, 'PlayStation 5 Pro', 799.99, 3, 'Consola', 'Sony', 'La consola más potente de Sony con IA avanzada y trazado de rayos mejorado.', 'productos/consolas/ps5/ps5-pro.webp', 'PS5', 1, '825GB', 'playstation-5-pro'),
(172, 'PlayStation 5 Slim - Pack NBA 2K26', 599.90, 5, 'Consola', 'Sony', 'Incluye consola PS5 Slim con lector de discos y el juego NBA 2K26.', 'productos/consolas/ps5/ps5-nba2k26-con-disco.webp', 'PS5', 1, '825GB', 'playstation-5-slim-pack-nba-2k26'),
(173, 'PlayStation 5 Slim Digital - Pack FC 26', 499.00, 7, 'Consola', 'Sony', 'Consola digital con el simulador de fútbol EA Sports FC 26 incluido.', 'productos/consolas/ps5/ps5-slim-digital-fc26.webp', 'PS5', 0, '825GB', 'playstation-5-slim-digital-pack-fc-26'),
(174, 'PlayStation 5 Slim Digital - Pack Fortnite', 449.99, 9, 'Consola', 'Sony', 'Edición digital con contenido exclusivo para Fortnite incluido en la caja.', 'productos/consolas/ps5/ps5-slim-digital-fornite.webp', 'PS5', 0, '825GB', 'playstation-5-slim-digital-pack-fortnite'),
(175, 'Xbox Series X - 1TB Standard', 499.00, 7, 'Consola', 'Microsoft', 'La Xbox más rápida y potente de la historia con lector de discos.', 'productos/consolas/xbox-series-sx/xbox-series-x-1tb.webp', 'Xbox', 1, '1TB', 'xbox-series-x-1tb-standard'),
(176, 'Xbox Series X - 2TB Galaxy Black Special Edition', 599.99, 2, 'Consola', 'Microsoft', 'Edición especial con 2TB de almacenamiento y diseño Galaxy Black.', 'productos/consolas/xbox-series-sx/xbox-series-x-2tb.webp', 'Xbox', 1, '2TB', 'xbox-series-x-2tb-galaxy-black-special-edition'),
(177, 'Xbox Series S - 1TB Carbon Black', 349.00, 6, 'Consola', 'Microsoft', 'Rendimiento de nueva generación en color negro con 1TB de SSD.', 'productos/consolas/xbox-series-sx/xbox-series-s-negra.webp', 'Xbox', 0, '512GB', 'xbox-series-s-1tb-carbon-black'),
(178, 'Xbox Series S - 512GB Standard', 289.00, 11, 'Consola', 'Microsoft', 'La consola Xbox más pequeña y elegante de la historia, totalmente digital.', 'productos/consolas/xbox-series-sx/xbox-one-series-s.webp', 'Xbox', 0, '512GB', 'xbox-series-s-512gb-standard'),
(179, 'Xbox Series S - Pack Starter con 2 Mandos', 319.99, 4, 'Consola', 'Microsoft', 'Incluye consola Xbox Series S de 512GB y un segundo mando extra.', 'productos/consolas/xbox-series-sx/xbox-one-series-s-dos-mandos.webp', 'Xbox', 0, '512GB', 'xbox-series-s-pack-starter-con-2-mandos'),
(180, 'Xbox Series S - Pack Gilded Hunter (Fortnite/Rocket League/Fall Guys)', 299.00, 5, 'Consola', 'Microsoft', 'Incluye contenido extra para Fortnite, Rocket League y Fall Guys.', 'productos/consolas/xbox-series-sx/xbox-one-series-s-fortnite-rl-fg-512gb.webp', 'Xbox', 0, '512GB', 'xbox-series-s-pack-gilded-hunter-fortnite-rocket-league-fall-guys'),
(181, 'Xbox Series X - Edición Especial Halo Infinite', 549.99, 3, 'Consola', 'Microsoft', 'Edición limitada 20 aniversario con diseño inspirado en el universo de Halo.', 'productos/consolas/xbox-series-sx/xbox-series-x-halo-infinte.webp', 'Xbox', 1, '1TB', 'xbox-series-x-edicion-especial-halo-infinite'),
(182, 'Xbox Series X - Pack Diablo IV 1TB', 529.00, 4, 'Consola', 'Microsoft', 'Incluye consola Xbox Series X y el juego Diablo IV para la mejor experiencia RPG.', 'productos/consolas/xbox-series-sx/xbox-series-x-diablo-1tb.webp', 'Xbox', 1, '1TB', 'xbox-series-x-pack-diablo-iv-1tb'),
(183, 'Xbox Series X - 1TB Digital Edition Blanca', 449.99, 6, 'Consola', 'Microsoft', 'Versión totalmente digital de la Series X en color Robot White con 1TB SSD.', 'productos/consolas/xbox-series-sx/xbox-series-x-blanco-1tb-digital.webp', 'Xbox', 1, '1TB', 'xbox-series-x-1tb-digital-edition-blanca'),
(184, 'Xbox Series S - Pack Gilded Hunter (Fortnite & Rocket League)', 299.00, 10, 'Consola', 'Microsoft', 'Incluye consola Series S y packs de cosméticos para Fortnite y Rocket League.', 'productos/consolas/xbox-series-sx/xbox-series-s-fortnite-rocketleague.webp', 'Xbox', 0, '512GB', 'xbox-series-s-pack-gilded-hunter-fortnite-y-rocket-league'),
(185, 'Xbox One S - Pack Forza Horizon 4', 249.00, 2, 'Consola', 'Microsoft', 'Consola Xbox One S de 1TB con el juego Forza Horizon 4 incluido.', 'productos/consolas/xbox-series-sx/xbox-one-s-forza-horizon4.webp', 'Xbox', 1, '1TB', 'xbox-one-s-pack-forza-horizon-4'),
(186, 'Xbox One S - Starter Pack', 229.99, 4, 'Consola', 'Microsoft', 'Pack de inicio que incluye la consola Xbox One S y 3 meses de Game Pass.', 'productos/consolas/xbox-series-sx/xbox-one-s-starterpack.webp', 'Xbox', 1, '1TB', 'xbox-one-s-starter-pack'),
(187, 'Control DualSense - Edición Limitada Astro Bot', 79.99, 5, 'Accesorio', 'Dualsense', 'El mando DualSense edición Astro Bot destaca por su diseño exclusivo inspirado en el popular personaje.\nOfrece vibración háptica y gatillos adaptativos que mejoran la inmersión.\nSu ergonomía permite largas sesiones sin fatiga.\nIncluye batería recargable y micrófono integrado.\nIdeal para coleccionistas.', 'productos/accesorios/ps5/dualsense-astrobot-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-edicion-limitada-astro-bot'),
(188, 'Control DualSense - Edición 30 Aniversario', 79.99, 3, 'Accesorio', 'Dualsense', 'La edición 30 Aniversario del DualSense rinde homenaje a la primera PlayStation.\nIncluye funciones avanzadas como vibración háptica.\nDiseño icónico para coleccionistas.\nGran comodidad y precisión.\nPerfecto para fans nostálgicos.', 'productos/accesorios/ps5/dualsense-30aniversario-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-edicion-30-aniversario'),
(189, 'Control DualSense - Starlight Blue', 69.99, 10, 'Accesorio', 'Dualsense', 'DualSense Starlight Blue con acabado moderno en azul vibrante.\nTecnología háptica para mayor realismo.\nGatillos adaptativos precisos.\nBatería de larga duración.\nIdeal para estilo y rendimiento.', 'productos/accesorios/ps5/dualsense-azul-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-starlight-blue'),
(190, 'Control DualSense - White Standard', 69.99, 15, 'Accesorio', 'Dualsense', 'DualSense White Standard es el mando oficial de PS5.\nOfrece experiencia inmersiva con vibración.\nGatillos adaptativos avanzados.\nDiseño ergonómico cómodo.\nPerfecto como mando principal.', 'productos/accesorios/ps5/dualsense-blanco-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-white-standard'),
(191, 'Control DualSense - Chroma Teal', 74.99, 8, 'Accesorio', 'Dualsense', 'DualSense Chroma Teal con acabado que cambia según la luz.\nTecnología háptica avanzada.\nCómodo para largas sesiones.\nBatería recargable incluida.\nDiseño único y llamativo.', 'productos/accesorios/ps5/dualsense-chromateal-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-chroma-teal'),
(192, 'Estación de Carga DualSense', 29.99, 12, 'Accesorio', 'Cargadores', 'Estación de carga DualSense para dos mandos.\nEvita cables y mantiene orden.\nIndicadores LED de carga.\nDiseño compacto.\nMuy práctico para uso diario.', 'productos/accesorios/ps5/dualsense-charging-station-ps5.webp', 'PS5', NULL, NULL, 'estacion-de-carga-dualsense'),
(193, 'Ventilador de Refrigeración Externo (Blanco)', 24.99, 20, 'Accesorio', 'Ventiladores', 'Ventilador externo para PS5 que mejora la refrigeración.\nReduce sobrecalentamiento.\nFácil instalación.\nMejora rendimiento.\nAlarga vida útil.', 'productos/accesorios/ps5/cooling-fan-blanco-ps5.webp', 'PS5', NULL, NULL, 'ventilador-de-refrigeracion-externo-blanco'),
(194, 'Cable de Carga USB-C Reforzado', 14.99, 50, 'Accesorio', 'Cables', 'Cable USB-C reforzado para carga rápida.\nAlta velocidad de transferencia.\nMaterial resistente.\nCompatible con varios dispositivos.\nIdeal como repuesto.', 'productos/accesorios/ps5/cable-usb-cargador-ps5.webp', 'PS5', NULL, NULL, 'cable-de-carga-usb-c-reforzado'),
(195, 'Batería Portátil para DualSense', 19.99, 15, 'Accesorio', 'Cargadores', 'Batería portátil para DualSense.\nAmplía sesiones de juego.\nFácil acople.\nCompacta y ligera.\nPerfecta para largas partidas.', 'productos/accesorios/ps5/bateria-portatil-dualsenseps5.webp', 'PS5', NULL, NULL, 'bateria-portatil-para-dualsense'),
(196, 'Kit de Personalización - Demon Slayer Edition', 34.99, 3, 'Accesorio', 'Fundas y estuches', 'Kit Demon Slayer para personalizar mando.\nDiseño inspirado en el anime.\nFácil instalación.\nMaterial resistente.\nIdeal para fans.', 'productos/accesorios/ps5/custom-kit-demon-slayer-dualsense5.webp', 'PS5', NULL, NULL, 'kit-de-personalizacion-demon-slayer-edition'),
(197, 'Control DualSense Edge - Pro Controller', 239.99, 5, 'Accesorio', 'Dualsense', 'DualSense Edge es un mando profesional.\nBotones traseros configurables.\nPalancas intercambiables.\nMáxima precisión.\nPara jugadores exigentes.', 'productos/accesorios/ps5/dualsense-edge-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-edge-pro-controller'),
(198, 'Control DualSense - Edición Especial Ghost of Yotei', 84.99, 4, 'Accesorio', 'Dualsense', 'Edición Ghost of Yotei con diseño artístico.\nTecnología háptica avanzada.\nGran ergonomía.\nAlta calidad de construcción.\nPerfecto para coleccionistas.', 'productos/accesorios/ps5/dualsense-ghost-of-yotei-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-edicion-especial-ghost-of-yotei'),
(199, 'Control DualSense - Edición Spider-Man 2', 79.99, 3, 'Accesorio', 'Dualsense', 'DualSense Spider-Man 2 con diseño exclusivo.\nInspirado en Venom.\nFunciones avanzadas.\nGran comodidad.\nIdeal para fans de Marvel.', 'productos/accesorios/ps5/dualsense-spiderman2-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-edicion-spider-man-2'),
(200, 'Control DualSense - Edición God of War Ragnarök', 79.99, 2, 'Accesorio', 'Dualsense', 'Edición God of War con diseño nórdico.\nAlta inmersión con vibración.\nGran precisión.\nErgonómico.\nPara fans de Kratos.', 'productos/accesorios/ps5/dualsense-gowragnarok-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-edicion-god-of-war-ragnar-k'),
(201, 'Control DualSense - Edición Final Fantasy XVI', 84.99, 3, 'Accesorio', 'Dualsense', 'DualSense Final Fantasy XVI edición premium.\nDetalles dorados elegantes.\nFunciones avanzadas.\nGran comodidad.\nPerfecto para coleccionistas.', 'productos/accesorios/ps5/dualsense-finalfantasyxvi-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-edicion-final-fantasy-xvi'),
(202, 'Control DualSense - Edición Concord', 74.99, 6, 'Accesorio', 'Dualsense', 'DualSense Concord con diseño colorido.\nTecnología avanzada.\nCómodo y preciso.\nBatería duradera.\nIdeal para destacar.', 'productos/accesorios/ps5/dualsense-concord-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-edicion-concord'),
(203, 'Control DualSense - Midnight Black', 69.99, 12, 'Accesorio', 'Dualsense', 'DualSense Midnight Black con acabado elegante.\nInspirado en el espacio.\nGran precisión.\nDiseño cómodo.\nPerfecto para cualquier setup.', 'productos/accesorios/ps5/dualsense-negro-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-midnight-black'),
(204, 'Control DualSense - Cosmic Red', 74.99, 10, 'Accesorio', 'Dualsense', 'DualSense Cosmic Red con color llamativo.\nFunciones avanzadas.\nGran ergonomía.\nAlta calidad.\nIdeal para destacar.', 'productos/accesorios/ps5/dualsense-rojocosmico-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-cosmic-red'),
(205, 'Control DualSense - Galactic Purple', 74.99, 8, 'Accesorio', 'Dualsense', 'DualSense Galactic Purple con tono único.\nTecnología háptica.\nCómodo.\nDuradero.\nPara colección galáctica.', 'productos/accesorios/ps5/dualsense-purple-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-galactic-purple'),
(206, 'Control DualSense - Gray Camouflage', 69.99, 15, 'Accesorio', 'Dualsense', 'DualSense Gray Camouflage con diseño urbano.\nFunciones avanzadas.\nGran agarre.\nErgonómico.\nEstilo moderno.', 'productos/accesorios/ps5/dualsense-greycamo-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-gray-camouflage'),
(207, 'Control DualSense - Edición Limitada The Last of Us Part II', 84.99, 3, 'Accesorio', 'Dualsense', 'Edición The Last of Us con grabado exclusivo.\nAlta calidad.\nGran inmersión.\nDiseño único.\nPara fans del juego.', 'productos/accesorios/ps5/dualsense-the-last-of-us-ps5.webp', 'PS5', NULL, NULL, 'control-dualsense-edicion-limitada-the-last-of-us-part-ii'),
(208, 'Módulo de Joystick reemplazable para DualSense Edge', 24.99, 15, 'Accesorio', 'Dualsense', 'Módulo joystick para DualSense Edge.\nRepuesto oficial.\nFácil instalación.\nMantiene rendimiento.\nIdeal para mantenimiento.', 'productos/accesorios/ps5/stick-module-dualsense5.webp', 'PS5', NULL, NULL, 'modulo-de-joystick-reemplazable-para-dualsense-edge'),
(209, 'Cable HDMI 2.1 de Alta Velocidad (Hori)', 29.99, 20, 'Accesorio', 'Cables', 'Cable HDMI 2.1 compatible con 4K y 8K.\nAlta velocidad.\nIdeal para PS5.\nSeñal estable.\nPerfecto para gaming.', 'productos/accesorios/ps5/ps5-hdmi21hori-ps5.webp', 'PS5', NULL, NULL, 'cable-hdmi-2-1-de-alta-velocidad-hori'),
(210, 'Memoria SSD NVMe M.2 4TB con Disipador', 399.99, 5, 'Accesorio', 'Memorias', 'SSD NVMe 4TB para ampliar almacenamiento.\nAlta velocidad.\nCompatible con PS5.\nGran capacidad.\nIdeal para muchos juegos.', 'productos/accesorios/ps5/memoria-ssd-4tb-ps5.webp', 'PS5', NULL, '4TB', 'memoria-ssd-nvme-m-2-4tb-con-disipador'),
(211, 'Control Remoto Multimedia PS5', 29.99, 12, 'Accesorio', 'Dualsense', 'Control remoto multimedia PS5.\nNavegación sencilla.\nIdeal para streaming.\nDiseño compacto.\nMuy práctico.', 'productos/accesorios/ps5/media-remote-ps5.webp', 'PS5', NULL, NULL, 'control-remoto-multimedia-ps5'),
(212, 'Cámara HD PlayStation 5', 59.99, 7, 'Accesorio', 'Camaras', 'Cámara HD PS5 con doble lente.\nResolución 1080p.\nIdeal para streaming.\nFácil configuración.\nBuena calidad de imagen.', 'productos/accesorios/ps5/hd-camera-ps5.webp', 'PS5', 1, '825GB', 'camara-hd-playstation-5'),
(213, 'Funda Rígida de Transporte para DualSense', 19.99, 25, 'Accesorio', 'Fundas y estuches', 'Funda rígida para DualSense.\nProtección segura.\nMaterial resistente.\nFácil transporte.\nIdeal para viajes.', 'productos/accesorios/ps5/funda-rigida-dualsense-ps5.webp', 'PS5', NULL, NULL, 'funda-rigida-de-transporte-para-dualsense'),
(214, 'Estuche de Transporte Deluxe para PS5', 64.99, 6, 'Accesorio', 'Fundas y estuches', 'Estuche de transporte PS5.\nGran capacidad.\nProtección acolchada.\nEspacio para accesorios.\nIdeal para viajar.', 'productos/accesorios/ps5/estuche-de-transporte-ps5.webp', 'PS5', NULL, NULL, 'estuche-de-transporte-deluxe-para-ps5'),
(215, 'Soporte Vertical para PS5 Slim / Pro', 29.99, 9, 'Accesorio', 'Soportes', 'Soporte vertical PS5.\nEstabilidad garantizada.\nDiseño elegante.\nFácil instalación.\nAhorra espacio.', 'productos/accesorios/ps5/estante-vertical-ps5.webp', 'PS5', NULL, NULL, 'soporte-vertical-para-ps5-slim-pro'),
(216, 'Mando DualSense Edge - White Edition', 239.99, 4, 'Accesorio', 'Dualsense', 'DualSense Edge White Edition profesional.\nAltamente personalizable.\nGran precisión.\nMaterial premium.\nPara gamers avanzados.', 'productos/accesorios/ps5/mando-dualsense-edge-blanco.webp', 'PS5', NULL, NULL, 'mando-dualsense-edge-white-edition'),
(217, 'Control Inalámbrico Xbox - Carbon Black', 59.99, 15, 'Accesorio', 'Mandos', 'Mando Xbox Carbon Black con diseño ergonómico.\nAgarre texturizado.\nGran precisión.\nCompatible con PC.\nIdeal para uso diario.', 'productos/accesorios/xbox-series-sx/mando-carbon-black-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-carbon-black'),
(218, 'Control Inalámbrico Xbox - Shock Blue', 64.99, 10, 'Accesorio', 'Mandos', 'Mando Xbox Shock Blue vibrante.\nAlta precisión.\nBuen agarre.\nConectividad Bluetooth.\nDiseño llamativo.', 'productos/accesorios/xbox-series-sx/mando-azul-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-shock-blue'),
(219, 'Control Xbox - Edición Especial Cyberpunk 2077', 89.99, 2, 'Accesorio', 'Mandos', 'Edición Cyberpunk 2077 coleccionista.\nDiseño único.\nAlta calidad.\nGran ergonomía.\nIdeal para fans.', 'productos/accesorios/xbox-series-sx/mando-cyberpunk-xbox.webp', 'Xbox', NULL, NULL, 'control-xbox-edicion-especial-cyberpunk-2077'),
(220, 'Seagate Game Drive para Xbox 2TB', 94.99, 8, 'Accesorio', 'Memorias', 'Disco duro Seagate 2TB.\nGran almacenamiento.\nFácil uso.\nAlta velocidad.\nIdeal para juegos.', 'productos/accesorios/xbox-series-sx/game-drive-xbox.webp', 'Xbox', NULL, '2TB', 'seagate-game-drive-para-xbox-2tb'),
(221, 'Kit Carga y Juega Xbox + Cable USB-C', 24.99, 20, 'Accesorio', 'Cables', 'Kit carga y juega Xbox.\nBatería recargable.\nIncluye cable.\nJuega mientras carga.\nMuy práctico.', 'productos/accesorios/xbox-series-sx/kit-cargayjuega-cable-usb-xbox.webp', 'Xbox', NULL, NULL, 'kit-carga-y-juega-xbox-cable-usb-c'),
(222, 'Batería Externa Recargable de Alta Duración', 19.99, 25, 'Accesorio', 'Baterías', 'Batería externa Xbox.\nMayor duración.\nFácil reemplazo.\nCompacta.\nIdeal para largas sesiones.', 'productos/accesorios/xbox-series-sx/bateria-remoto-xbox.webp', 'Xbox', NULL, NULL, 'bateria-externa-recargable-de-alta-duracion'),
(223, 'Maleta de Transporte Profesional para Xbox', 59.99, 5, 'Accesorio', 'Fundas y estuches', 'Maleta Xbox resistente.\nProtección acolchada.\nEspacio amplio.\nFácil transporte.\nIdeal viajes.', 'productos/accesorios/xbox-series-sx/maleta-viajera-xbox.webp', 'Xbox', NULL, NULL, 'maleta-de-transporte-profesional-para-xbox'),
(224, 'Cable HDMI Ultra Alta Velocidad 2.1', 24.99, 30, 'Accesorio', 'Cables', 'Cable HDMI 2.1 Xbox.\nAlta velocidad.\nCompatible 4K 120Hz.\nSeñal estable.\nGaming óptimo.', 'productos/accesorios/xbox-series-sx/hdmi-ultraaltavelocidad-xbox.webp', 'Xbox', NULL, NULL, 'cable-hdmi-ultra-alta-velocidad-2-1'),
(225, 'Kit de Personalización - Batman Edition', 29.99, 6, 'Accesorio', 'Fundas y estuches', 'Kit Batman personalización.\nDiseño temático.\nFácil instalación.\nMaterial resistente.\nIdeal fans.', 'productos/accesorios/xbox-series-sx/custom-kit-batman-mandoxbox.webp', 'Xbox', NULL, NULL, 'kit-de-personalizacion-batman-edition'),
(226, 'Grips de Precisión para Joysticks', 9.99, 40, 'Accesorio', 'Grips', 'Grips para joystick.\nMejor agarre.\nMayor precisión.\nFácil colocación.\nMejora rendimiento.', 'productos/accesorios/xbox-series-sx/grips-mando-xbox.webp', 'Xbox', NULL, NULL, 'grips-de-precision-para-joysticks'),
(227, 'Control Xbox Elite Series 2 - Black', 179.99, 5, 'Accesorio', 'Mandos', 'Xbox Elite Series 2 mando pro.\nAlta precisión.\nPersonalizable.\nMaterial premium.\nPara jugadores competitivos.', 'productos/accesorios/xbox-series-sx/mando-eliteseries2-negro-xbox.webp', 'Xbox', NULL, NULL, 'control-xbox-elite-series-2-black'),
(228, 'Control Xbox Elite Series 2 - Core White', 129.99, 8, 'Accesorio', 'Mandos', 'Xbox Elite Core White.\nAlto rendimiento.\nDiseño elegante.\nGran precisión.\nVersión accesible pro.', 'productos/accesorios/xbox-series-sx/mando-eliteseries2-blanco-xbox.webp', 'Xbox', NULL, NULL, 'control-xbox-elite-series-2-core-white'),
(229, 'Control Inalámbrico Xbox - Ghost Cipher Special Edition', 69.99, 4, 'Accesorio', 'Mandos', 'Ghost Cipher edición transparente.\nDiseño único.\nGran ergonomía.\nAlta calidad.\nIdeal colección.', 'productos/accesorios/xbox-series-sx/mando-ghostcipher-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-ghost-cipher-special-edition'),
(230, 'Control Inalámbrico Xbox - Dream Vapor Special Edition', 69.99, 6, 'Accesorio', 'Mandos', 'Dream Vapor con colores únicos.\nDiseño llamativo.\nGran precisión.\nCómodo.\nPara destacar.', 'productos/accesorios/xbox-series-sx/mando-dream-vapor-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-dream-vapor-special-edition'),
(231, 'Control Inalámbrico Xbox - Nocturnal Vapor Special Edition', 69.99, 7, 'Accesorio', 'Mandos', 'Nocturnal Vapor oscuro.\nEstilo elegante.\nGran agarre.\nAlta precisión.\nPerfecto gaming.', 'productos/accesorios/xbox-series-sx/mando-nocturnal-vapor-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-nocturnal-vapor-special-edition'),
(232, 'Control Inalámbrico Xbox - Pulse Red', 64.99, 12, 'Accesorio', 'Mandos', 'Pulse Red intenso.\nDiseño moderno.\nGran ergonomía.\nAlta calidad.\nIdeal para destacar.', 'productos/accesorios/xbox-series-sx/mando-pulse-red-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-pulse-red'),
(233, 'Control Inalámbrico Xbox - Daystrike Camo Special Edition', 69.99, 5, 'Accesorio', 'Mandos', 'Daystrike camo rojo.\nDiseño agresivo.\nBuen agarre.\nAlta precisión.\nEstilo único.', 'productos/accesorios/xbox-series-sx/mando-daystrike-camo-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-daystrike-camo-special-edition'),
(234, 'Control Inalámbrico Xbox - Mineral Camo Special Edition', 69.99, 6, 'Accesorio', 'Mandos', 'Mineral camo colores únicos.\nDiseño creativo.\nGran ergonomía.\nAlta calidad.\nPara coleccionistas.', 'productos/accesorios/xbox-series-sx/mando-mineral-camo-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-mineral-camo-special-edition'),
(235, 'Control Inalámbrico Xbox - Ice Breaker (PDP Rematch)', 44.99, 10, 'Accesorio', 'Mandos', 'Ice Breaker mando cableado.\nBotones programables.\nAlta respuesta.\nDiseño gélido.\nIdeal competitivo.', 'productos/accesorios/xbox-series-sx/mando-ice-breaker-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-ice-breaker-pdp-rematch'),
(236, 'Control Inalámbrico Xbox - Spirit Red (PDP Rematch)', 44.99, 9, 'Accesorio', 'Mandos', 'Spirit Red PDP.\nPersonalizable por app.\nGran precisión.\nDiseño moderno.\nBuen rendimiento.', 'productos/accesorios/xbox-series-sx/mando-rematch-spiritit-red-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-spirit-red-pdp-rematch'),
(237, 'Control Inalámbrico Xbox - Robot White', 59.99, 20, 'Accesorio', 'Mandos', 'Robot White clásico.\nGran ergonomía.\nAlta precisión.\nBotón compartir.\nIdeal uso diario.', 'productos/accesorios/xbox-series-sx/mando-robot-white-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-robot-white'),
(238, 'Control Inalámbrico Xbox - Stellar Shift Special Edition', 69.99, 5, 'Accesorio', 'Mandos', 'Stellar Shift efecto brillante.\nDiseño premium.\nGran agarre.\nAlta calidad.\nColeccionable.', 'productos/accesorios/xbox-series-sx/mando-stellar-shift-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-stellar-shift-special-edition'),
(239, 'Control Inalámbrico Xbox - Stormcloud Vapor', 69.99, 4, 'Accesorio', 'Mandos', 'Stormcloud Vapor diseño dinámico.\nGran precisión.\nCómodo.\nAlta calidad.\nEstilo único.', 'productos/accesorios/xbox-series-sx/mando-storm-breaker-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-stormcloud-vapor'),
(240, 'Control Inalámbrico Xbox - Velocity Green', 64.99, 8, 'Accesorio', 'Mandos', 'Velocity Green icónico.\nColor vibrante.\nGran ergonomía.\nAlta precisión.\nPerfecto Xbox.', 'productos/accesorios/xbox-series-sx/mando-velocity-green-xbox.webp', 'Xbox', NULL, NULL, 'control-inalambrico-xbox-velocity-green'),
(241, 'Control Xbox - Edición Limitada Starfield', 84.99, 2, 'Accesorio', 'Mandos', 'Starfield edición limitada.\nDiseño espacial.\nAlta calidad.\nGran detalle.\nPara fans.', 'productos/accesorios/xbox-series-sx/mando-xbox-starfield.webp', 'Xbox', NULL, NULL, 'control-xbox-edicion-limitada-starfield'),
(242, 'Control Xbox - Edición Especial DOOM', 79.99, 3, 'Accesorio', 'Mandos', 'DOOM edición agresiva.\nDiseño Slayer.\nAlta calidad.\nGran precisión.\nPara fans.', 'productos/accesorios/xbox-series-sx/mando-xbox-doom.webp', 'Xbox', NULL, NULL, 'control-xbox-edicion-especial-doom'),
(243, 'Auriculares Inalámbricos Xbox (Microsoft)', 99.99, 10, 'Accesorio', 'Auriculares', 'Auriculares Xbox inalámbricos.\nSonido envolvente.\nMicrófono integrado.\nGran comodidad.\nIdeal online.', 'productos/accesorios/xbox-series-sx/miscrosoftxbox-headset.webp', 'Xbox', NULL, NULL, 'auriculares-inalambricos-xbox-microsoft'),
(244, 'Palanca de Vuelo Thrustmaster T.Flight Hotas One', 89.99, 5, 'Accesorio', 'Simuladores', 'Joystick vuelo Thrustmaster.\nAlta precisión.\nControl realista.\nCompatible Xbox.\nIdeal simuladores.', 'productos/accesorios/xbox-series-sx/palanca-de-mando-xbox-thrustmaster.webp', 'Xbox', NULL, NULL, 'palanca-de-vuelo-thrustmaster-t-flight-hotas-one'),
(245, 'Volante Logitech G923 TRUEFORCE para Xbox', 349.00, 3, 'Accesorio', 'Simuladores', 'Volante Logitech G923.\nTecnología TrueForce.\nPedales incluidos.\nAlta precisión.\nSimulación realista.', 'productos/accesorios/xbox-series-sx/volante-logitech-g923-xbox.webp', 'Xbox', NULL, NULL, 'volante-logitech-g923-trueforce-para-xbox'),
(246, 'Mando Scuf Instinct Pro para Xbox Elite', 219.99, 2, 'Accesorio', 'Mandos', 'Scuf Instinct Pro.\nPaletas traseras.\nAlta personalización.\nGran rendimiento.\nNivel competitivo.', 'productos/accesorios/xbox-series-sx/scuf-elite-xbox-elite-series-1y2.webp', 'Xbox', NULL, NULL, 'mando-scuf-instinct-pro-para-xbox-elite'),
(247, 'Amiibo Mario (Wedding Outfit) - Super Mario Odyssey', 19.99, 10, 'Accesorio', 'Figuras', 'Amiibo Mario boda.\nFigura coleccionable.\nCompatible juegos.\nAlta calidad.\nIdeal fans Nintendo.', 'productos/accesorios/nintendo-switch/figura-amiibo-mario-odyssey-nintendo-switch.webp', 'Switch', NULL, NULL, 'amiibo-mario-wedding-outfit-super-mario-odyssey'),
(248, 'Amiibo Bowser (Wedding Outfit) - Super Mario Odyssey', 19.99, 8, 'Accesorio', 'Figuras', 'Amiibo Bowser boda.\nDiseño elegante.\nCompatible juegos.\nAlta calidad.\nColeccionable.', 'productos/accesorios/nintendo-switch/figura-amiibo-bowser-nintendo-switch.webp', 'Switch', NULL, NULL, 'amiibo-bowser-wedding-outfit-super-mario-odyssey'),
(249, 'Amiibo Samus Aran - Metroid Series', 19.99, 5, 'Accesorio', 'Figuras', 'Amiibo Samus.\nCompatible Metroid.\nAlta calidad.\nFigura detallada.\nIdeal colección.', 'productos/accesorios/nintendo-switch/figura-amiibo-samus-metroid.webp', 'Switch', NULL, NULL, 'amiibo-samus-aran-metroid-series'),
(250, 'Amiibo Sonic - Super Smash Bros. Collection', 19.99, 12, 'Accesorio', 'Figuras', 'Amiibo Sonic.\nFigura icónica.\nCompatible juegos.\nAlta calidad.\nPara fans.', 'productos/accesorios/nintendo-switch/figura-amiibo-sonic-nintendo-switch.webp', 'Switch', NULL, NULL, 'amiibo-sonic-super-smash-bros-collection'),
(251, 'Funda Protectora - Pokémon Edition', 24.99, 15, 'Accesorio', 'Fundas y protectores', 'Funda Pokémon.\nProtección rígida.\nDiseño temático.\nFácil transporte.\nIdeal viajes.', 'productos/accesorios/nintendo-switch/funda-nintendo-switch-de-pokemon.webp', 'Switch', NULL, NULL, 'funda-protectora-pokemon-edition'),
(252, 'Funda Protectora - Mario Kart World', 24.99, 20, 'Accesorio', 'Fundas y protectores', 'Funda Mario Kart.\nResistente.\nDiseño atractivo.\nProtección segura.\nIdeal transporte.', 'productos/accesorios/nintendo-switch/funda-mario-kart-world-nintendo-switch.webp', 'Switch', NULL, NULL, 'funda-protectora-mario-kart-world'),
(253, 'Funda Protectora - Boo (Mario Bros)', 24.99, 10, 'Accesorio', 'Fundas y protectores', 'Funda Boo.\nDiseño divertido.\nProtección sólida.\nLigera.\nIdeal Switch.', 'productos/accesorios/nintendo-switch/funda-fantasma-mario-bros-nintendo-switch.webp', 'Switch', NULL, NULL, 'funda-protectora-boo-mario-bros'),
(254, 'Soporte de Carga Ajustable Nintendo', 19.99, 12, 'Accesorio', 'Soportes', 'Soporte carga Nintendo.\nPermite jugar cargando.\nAjustable.\nCompacto.\nMuy útil.', 'productos/accesorios/nintendo-switch/estante-de-carga-ajustable-nintendo-switch.webp', 'Switch', NULL, NULL, 'soporte-de-carga-ajustable-nintendo'),
(255, 'Adaptador de Corriente Oficial Nintendo Switch', 29.99, 30, 'Accesorio', 'Adaptadores', 'Adaptador oficial Switch.\nCarga rápida.\nAlta seguridad.\nCompatible dock.\nEsencial.', 'productos/accesorios/nintendo-switch/adaptador-de-corriente-nintendo-switch.webp', 'Switch', NULL, NULL, 'adaptador-de-corriente-oficial-nintendo-switch'),
(256, 'Soporte de Carga para Joy-Con (Pilas AA)', 14.99, 15, 'Accesorio', 'Soportes', 'Soporte Joy-Con pilas.\nMayor autonomía.\nFácil uso.\nLigero.\nIdeal viajes.', 'productos/accesorios/nintendo-switch/cargador-con-pilasAA-con-joycon.webp', 'Switch', NULL, NULL, 'soporte-de-carga-para-joy-con-pilas-aa'),
(257, 'Control Pro Controller - Edición Yoshi', 64.99, 5, 'Accesorio', 'Controles', 'Pro Controller Yoshi.\nDiseño verde.\nAlta precisión.\nErgonómico.\nIdeal fans.', 'productos/accesorios/nintendo-switch/mando-pro-yoshi-nintendo-switch.webp', 'Switch', NULL, NULL, 'control-pro-controller-edicion-yoshi');
INSERT INTO `productos` (`id_producto`, `nombre`, `precio`, `stock`, `tipo`, `categoria`, `descripcion`, `img_url`, `plataforma`, `tieneLector`, `almacenamiento`, `slug`) VALUES
(258, 'Control Pro Controller - Edición Splatoon 3', 74.99, 4, 'Accesorio', 'Controles', 'Pro Controller Splatoon 3.\nDiseño colorido.\nGran agarre.\nAlta precisión.\nMuy llamativo.', 'productos/accesorios/nintendo-switch/mando-splatoo3-nintendo-switch.webp', 'Switch', NULL, NULL, 'control-pro-controller-edicion-splatoon-3'),
(259, 'Control Faceoff Deluxe+ - Zelda: Breath of the Wild', 39.99, 6, 'Accesorio', 'Controles', 'Faceoff Zelda mando.\nCableado.\nCarcasa intercambiable.\nBuen rendimiento.\nDiseño Zelda.', 'productos/accesorios/nintendo-switch/mando-faceoff-zelda-botw-azul-nintendo-switch.webp', 'Switch', NULL, NULL, 'control-faceoff-deluxe-zelda-breath-of-the-wild'),
(260, 'Control Pro Controller - Edición Super Mario', 64.99, 8, 'Accesorio', 'Controles', 'Pro Controller Mario.\nDiseño icónico.\nGran ergonomía.\nAlta precisión.\nIdeal fans.', 'productos/accesorios/nintendo-switch/mando-supermario-nintendo-switch.webp', 'Switch', NULL, NULL, 'control-pro-controller-edicion-super-mario'),
(261, 'Mando Horipad Mini - Super Mario Edition', 29.99, 12, 'Accesorio', 'Controles', 'Horipad Mini.\nCompacto.\nIdeal niños.\nLigero.\nFácil uso.', 'productos/accesorios/nintendo-switch/mando-horipad-mini-nintendo-switch.webp', 'Switch', NULL, NULL, 'mando-horipad-mini-super-mario-edition'),
(262, 'Set de Joy-Con - Rosa Pastel', 79.99, 7, 'Accesorio', 'Controles', 'Joy-Con rosa pastel.\nDiseño moderno.\nAlta precisión.\nVersátiles.\nIdeal Switch.', 'productos/accesorios/nintendo-switch/joycon-rosapastel-nintendo-switch.webp', 'Switch', NULL, NULL, 'set-de-joy-con-rosa-pastel'),
(263, 'Set de Joy-Con - Azul/Amarillo Neón', 79.99, 5, 'Accesorio', 'Controles', 'Joy-Con azul amarillo.\nColores vibrantes.\nGran funcionalidad.\nMultijugador.\nMuy versátiles.', 'productos/accesorios/nintendo-switch/joycon-blue-yellow-nintendo-switch.webp', 'Switch', NULL, NULL, 'set-de-joy-con-azul-amarillo-neon'),
(264, 'Set de Joy-Con - Rojo/Azul Neón', 79.99, 15, 'Accesorio', 'Controles', 'Joy-Con rojo azul.\nClásicos.\nAlta calidad.\nVersátiles.\nPerfectos Switch.', 'productos/accesorios/nintendo-switch/joycon-red-blue-nintendo-switch.webp', 'Switch', NULL, NULL, 'set-de-joy-con-rojo-azul-neon'),
(265, 'Maletín de Transporte Pro - Nintendo Switch', 39.99, 10, 'Accesorio', 'Fundas y protectores', 'Maletín Switch Pro.\nGran capacidad.\nProtección.\nTransporte seguro.\nIdeal viajes.', 'productos/accesorios/nintendo-switch/maletin-para-nintendo-swicth.webp', 'Switch', 1, '32GB', 'maletin-de-transporte-pro-nintendo-switch'),
(266, 'Set de Funda y Protector de Pantalla OLED', 24.99, 20, 'Accesorio', 'Fundas y protectores', 'Funda + protector OLED.\nProtección completa.\nMaterial resistente.\nFácil uso.\nIdeal cuidado.', 'productos/accesorios/nintendo-switch/funda-y-protector-de-pantalla-nintendo-switch-oled.webp', 'Switch', NULL, NULL, 'set-de-funda-y-protector-de-pantalla-oled'),
(267, 'Control Pro Controller - Black Standard', 59.90, 15, 'Accesorio', 'Controles', 'Pro Controller negro.\nOficial.\nAlta precisión.\nErgonómico.\nMuy cómodo.', 'productos/accesorios/nintendo-switch/nintendo-switch-mando-pro-negro.webp', 'Switch', NULL, NULL, 'control-pro-controller-black-standard'),
(268, 'Set de Base Nintendo Switch (Dock Set)', 89.99, 5, 'Accesorio', 'Soportes', 'Dock Switch.\nIncluye accesorios.\nFácil conexión.\nAlta calidad.\nEsencial.', 'productos/accesorios/nintendo-switch/set-base-nintendo-switch.webp', 'Switch', 1, '32GB', 'set-de-base-nintendo-switch-dock-set'),
(269, 'Tarjeta MicroSDXC SanDisk para Nintendo Switch - 1TB', 149.99, 4, 'Accesorio', 'Memorias', 'MicroSD 1TB.\nGran capacidad.\nAlta velocidad.\nIdeal juegos.\nMucho espacio.', 'productos/accesorios/nintendo-switch/microsd-sandisk-1tb-nintendo-switch.webp', 'Switch', 1, '1TB', 'tarjeta-microsdxc-sandisk-para-nintendo-switch-1tb'),
(270, 'Tarjeta MicroSDXC SanDisk para Nintendo Switch - 512GB', 64.99, 10, 'Accesorio', 'Memorias', 'MicroSD 512GB.\nRápida.\nFiable.\nBuen almacenamiento.\nIdeal Switch.', 'productos/accesorios/nintendo-switch/microsd-sandisk-512gb-nintendo-switch.webp', 'Switch', 1, '512GB', 'tarjeta-microsdxc-sandisk-para-nintendo-switch-512gb'),
(271, 'Tarjeta MicroSDXC Pokémon Edition - 1TB (Pikachu)', 159.00, 3, 'Accesorio', 'Memorias', 'MicroSD Pokémon 1TB.\nEdición especial.\nGran capacidad.\nAlta velocidad.\nColeccionable.', 'productos/accesorios/nintendo-switch/microsd-pokemon-cards-1tb.webp', 'Switch', NULL, '1TB', 'tarjeta-microsdxc-pokemon-edition-1tb-pikachu'),
(272, 'Tarjeta MicroSDXC Pokémon Edition - 512GB (Gengar)', 69.99, 6, 'Accesorio', 'Memorias', 'MicroSD Gengar 512GB.\nDiseño temático.\nAlta velocidad.\nFiable.\nIdeal gaming.', 'productos/accesorios/nintendo-switch/microsd-pokemon-cards-512gb.webp', 'Switch', NULL, '512GB', 'tarjeta-microsdxc-pokemon-edition-512gb-gengar'),
(273, 'Tarjeta MicroSDXC Pokémon Edition - 256GB (Pokéball)', 39.99, 12, 'Accesorio', 'Memorias', 'MicroSD Pokeball 256GB.\nDiseño único.\nBuena capacidad.\nRápida.\nIdeal Switch.', 'productos/accesorios/nintendo-switch/microsd-pokemon-256gb-nintendo-switch.webp', 'Switch', NULL, '256GB', 'tarjeta-microsdxc-pokemon-edition-256gb-pokeball'),
(274, 'Tarjeta MicroSDXC Samsung EVO Select - 256GB', 34.99, 20, 'Accesorio', 'Memorias', 'MicroSD Samsung 256GB.\nAlta fiabilidad.\nBuena velocidad.\nCompatible.\nUso diario.', 'productos/accesorios/nintendo-switch/micro-sd256gb-samsung-nintendo-switch.webp', 'Switch', NULL, '256GB', 'tarjeta-microsdxc-samsung-evo-select-256gb'),
(275, 'Protector de Pantalla de Cristal Templado (Anti-Luz Azul)', 12.99, 48, 'Accesorio', 'Fundas y protectores', 'Protector pantalla templado.\nAlta resistencia.\nFiltro luz azul.\nProtege pantalla.\nFácil instalación.', 'productos/accesorios/nintendo-switch/protector-pantalla-templado-antirayos-azules-nintendo-switch.webp', 'Switch', NULL, NULL, 'protector-de-pantalla-de-cristal-templado-anti-luz-azul'),
(282, 'FIFA 26', 69.99, 5, 'Juego', 'Deportes', 'EA SPORTS FC 26, lanzado el 26 de septiembre de 2025, es el simulador de fútbol definitivo que trae jugabilidad renovada con IA mejorada, regates ágiles y animaciones realistas basadas en la comunidad.', 'productos/videojuegos/deporte/ea-sports-fc-26-caratula.webp', 'PS5', NULL, NULL, 'fifa-26-ps5'),
(294, 'Resident Evil 7', 29.99, 12, 'Juego', 'Terror', 'Biohazard marca un reinicio terrorífico en la aclamada saga de supervivencia RE. En primera persona, los jugadores encarnan a Ethan Winters, quien busca a su esposa desaparecida en una plantación abandonada en Luisiana, dominada por la familia Baker, unos lugareños infectados y caníbales. Este título se centra en el horror psicológico, la exploración, los acertijos y la gestión estricta de recursos.', 'productos/videojuegos/terror/resident-evil-7.webp', 'PS5', 0, '', 'resident-evil-7-ps5');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `rol` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `email`, `contrasena`, `nombre`, `apellidos`, `rol`) VALUES
(45, 'tienda@ejemplo.com', '$2y$10$i9ZAcUJpD.VzFaXj1z9L7.QWlTzz9BMY1aXV/DKN1cphqv2kYVAvO', 'Victor', 'Cardenas Portugal', 'admin'),
(53, 'admin@ejemplo.com', '$2y$10$KjzSftg6s1lQ.9TUb06P9ej7/0Ovzm3h7WCID2v8SRC88vUf9ZspW', 'admin', 'adminsito', 'admin'),
(54, 'pepe@ejemplo.com', '$2y$10$qMUSDS5J3pGtmnDAF/MU9.yK4UVveD2iBQEG57Fmtaw4pbcCHkszi', 'Pepe', 'Lima Ferreira', 'user'),
(55, 'javier@ejemplo.com', '$2y$10$1620BG.71wng5M5whqrZVOg2f0vBm93PI9snmvv.H7JumJqqk4iwG', 'Javier', 'Liras Lara', 'user'),
(56, 'cristiano@ejemplo.com', '$2y$10$TnBjtvBIdLYzKb913uhyvORq4f8DbcBrIAMnQC/6msu6CLziJzVMK', 'Cristiano', 'Dos Santos Aveiro', 'user');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`producto_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `cupones`
--
ALTER TABLE `cupones`
  ADD PRIMARY KEY (`id_cupon`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `cupones_usuarios`
--
ALTER TABLE `cupones_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`,`id_cupon`),
  ADD KEY `id_cupon` (`id_cupon`);

--
-- Indices de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD PRIMARY KEY (`id_detalle`),
  ADD UNIQUE KEY `pedido_id` (`pedido_id`,`producto_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `cupon_id` (`cupon_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `cupones`
--
ALTER TABLE `cupones`
  MODIFY `id_cupon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `cupones_usuarios`
--
ALTER TABLE `cupones_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `carrito_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `carrito_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cupones_usuarios`
--
ALTER TABLE `cupones_usuarios`
  ADD CONSTRAINT `cupones_usuarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `cupones_usuarios_ibfk_2` FOREIGN KEY (`id_cupon`) REFERENCES `cupones` (`id_cupon`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD CONSTRAINT `detalles_pedidos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalles_pedidos_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`cupon_id`) REFERENCES `cupones` (`id_cupon`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
