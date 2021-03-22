function BIGetProvViaID(provID)
{
    return $.ajax({
        url: 'TaurAPI/Province/' + provID,
        type: 'GET',
        cache: false,
        dataType: 'json'
	});
}