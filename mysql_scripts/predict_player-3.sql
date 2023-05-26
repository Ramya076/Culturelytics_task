ALTER TABLE `players` CHANGE `type` `type` TINYINT NOT NULL COMMENT '1->All rounder 2->Bowler, 3->Batsman, 4->Wicket Keeper';



--
-- Table structure for table `predict_player`
--

CREATE TABLE `predict_player` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL COMMENT 'Reference of table ''players''',
  `score` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for table `predict_player`
--
ALTER TABLE `predict_player`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player_id` (`player_id`);

--
-- Constraints for table `predict_player`
--
-- AUTO_INCREMENT for table `predict_player`
--
ALTER TABLE `predict_player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

ALTER TABLE `predict_player`
  ADD CONSTRAINT `predict_player_ibfk_1` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`);
COMMIT;


