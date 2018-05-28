const dbHandler = require('../databaseHandlers/DBHandlerAnnouncement');
const express = require('express');
const router = express.Router();
var bodyParser = require('body-parser');
router.use(bodyParser.urlencoded({ extended: false }));


/*get all items*/
router.get('/',(req, res, next) => {	
	
	dbHandler.getAnnouncements(function(err,data){
		if(err){
			res.status(500).json({
				error: err
			});
		}else{
			res.status(200).json(data);
		}
	});
	
	
});


/*add new item*/
router.post('/',(req, res, next) => {
	const announcement_title = req.body.announcement_title;
	const announcement_text = req.body.announcement_text;
	const announcement_link = req.body.announcement_link;
	const admin = req.body.admin;
	if(announcement_title && announcement_text && announcement_link && admin){
		dbHandler.addAnnouncement(announcement_title, announcement_text, announcement_link, admin, function(err,data){
			if(err){
				res.status(500).json({
					error: err
				});
			}else{
				res.status(200).json(data);
			}
		});
	}else{
		res.status(500).json({error: 'invalid parameters'})
	}
	
	
});

/*get item id*/
router.get('/:announcementId',(req, res, next) => {
	const id = req.params.announcementId;
	dbHandler.getAnnouncementDetails(id,function(err,data){
		if(err){
			res.status(500).json({
				error: err
			});
		}else{
			res.status(200).json(data);
		}
	});
});


module.exports = router;

