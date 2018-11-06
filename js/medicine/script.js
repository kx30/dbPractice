$(document).ready(function(){

	let isCheck = false;
	let mainContainerIsHidden = false;
	$("input").attr("disabled", true);
	$(".hidden-container").find("input").removeAttr("disabled");

	replaceShow();
	$(".hidden-container").hide();

	$(document).on('click', "#addButton", function() {
		$(".shown-container").hide();
		$(".hidden-container").show();
		replaceShow();
	});

	$(document).on('click', "#cancelButton", function() {
		$(".shown-container").show();
		$(".hidden-container").hide();
	});

	$(document).on('click', "#acceptButton", function(e) {
		e.preventDefault();
		let form = $(this).parent();
		let inputs = $(this).parents(".hidden-container").find("input");
		let fields = [];
		let values = [];
		let types = "";
		let action = 'insert';
		let table = 'medicine';
		inputs.each(function() {
			fields.push($(this).attr('name'));
			values.push($(this).val());
			types += $(this).attr('data-type');
		})
		$.ajax({
			url: '../php/CRUD.php',
			type: 'POST',
			data: {
				table: table,
				action: action,
				fields: JSON.stringify(fields),
				values: JSON.stringify(values),
				types: types,
			},
			success: function(response) {
				console.log(response);
				location.reload();
			},
			error: function(error) {
				console.log(error);
			}
		})
	});

	$(document).on('click', "#editButton", function(e) {
		if (isCheck) {
			e.preventDefault();
			let form = $(this).parent();
			let inputs = $(this).parents(".input-container").find("input")
			let values = [];;
			let fields = [];
			let types = "";
			let action = 'update';
			let table = 'medicine';
			let id = $(this).parents(".input-container").find(".id_input").val();
			inputs.each(function() {
				fields.push($(this).attr('name'));
				values.push($(this).val());
				types += $(this).attr('data-type');
			})
			$.ajax({
				url: '../php/CRUD.php',
				type: 'POST',
				data: {
					table: table,
					action: action,
					id: id,
					fields: JSON.stringify(fields),
					values: JSON.stringify(values),
					types: types,
				},
				success: function(response) {
					console.log(response);	
					//location.reload();
				},
				error: function(error) {
					console.log(error);
				}
			})
			$(this).parents(".input-container").find(".fa-trash").show();	
			$(this).parents(".input-container").find(".fa-edit").show();
			$(this).parents(".input-container").find(".fa-close").hide();
			$(this).parents(".input-container").find(".fa-check").hide();
			$(this).parents(".input-container").find("input").attr("disabled", true); 
			isCheck = false;
		} else {
			$(this).parents(".input-container").find(".fa-edit").hide();
			$(this).parents(".input-container").find(".fa-trash").hide();
			$(this).parents(".input-container").find(".fa-check").show();
			$(this).parents(".input-container").find(".fa-close").show();
			$(this).parents(".input-container").find("input").removeAttr("disabled");
			isCheck = true;
		}
	});

	$(document).on('click', "#deleteButton", function(e) {
		if (isCheck) {
			$(this).parents(".input-container").find(".fa-trash").show();
			$(this).parents(".input-container").find(".fa-edit").show();
			$(this).parents(".input-container").find(".fa-close").hide();
			$(this).parents(".input-container").find(".fa-check").hide();
			$(this).parents(".input-container").find("input").attr("disabled", true);
			isCheck = false;
		} else {
			e.preventDefault();
			let form = $(this).parent();
			let inputs = $(this).parents(".hidden-container").find("input")
			let values = [];;
			let fields = [];
			let types = "";
			let action = 'delete';
			let table = 'medicine';
			let id = $(this).parents(".input-container").find(".id_input").val();
			console.log(id);
			inputs.each(function() {
				fields.push($(this).attr('name'));
				values.push($(this).val());
				types += $(this).attr('data-type');
			})
			$.ajax({
				url: '../php/CRUD.php',
				type: 'POST',
				data: {
					table: table,
					action: action,
					id: id,
					fields: JSON.stringify(fields),
					values: JSON.stringify(values),
					types: types,
				},
				success: function(response) {
					console.log(response);	
					//location.reload();
				},
				error: function(error) {
					console.log(error);
				}
			})
			let del = $(this).parent().parent();
			$(del).find("input").remove();
			$(del).find("button").remove();
			$(this).parents(".input-container").find(".fa-trash").hide();
			$(this).parents(".input-container").find(".fa-edit").hide();
			$(this).parents(".input-container").find(".fa-close").show();
			$(this).parents(".input-container").find(".fa-check").show();	
		}
	});

	function replaceShow() {
		$(".fa-trash").show();
		$(".fa-edit").show();
		$(".fa-close").hide();
		$(".fa-check").hide();
	}

	function replaceHide() {
		$(".fa-trash").hide();
		$(".fa-edit").hide();
		$(".fa-close").show();
		$(".fa-check").show();
	}


});
