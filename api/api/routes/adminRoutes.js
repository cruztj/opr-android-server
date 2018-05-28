const dbHandler = require('../databaseHandlers/DBHandlerAdmin');
const express = require('express');
const router = express.Router();
var bodyParser = require('body-parser');
router.use(bodyParser.urlencoded({ extended: false }));


/*get all items*/
router.get('/',(req, res, next) => {	
	
	dbHandler.getAdmins(function(err,data){
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
	const admin_email = req.body.admin_email;
	const admin_added_by = req.body.admin_added_by;
	if(admin_email && admin_added_by){
		dbHandler.addAdmin(admin_email, admin_added_by, function(err,data){
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
router.get('/:adminId',(req, res, next) => {
	const id = req.params.adminId;
	dbHandler.getAdminDetails(id,function(err,data){
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

