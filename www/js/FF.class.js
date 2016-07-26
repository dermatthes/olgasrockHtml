/**
 * Created by matthes on 29.07.14.
 */


//if (typeof FF == "undefined") {


    function FF () {

    }




    /**
     *
     * @param query
     * @param arguments
     * @return ResultSet
     */
    FF.sql = function (query, arguments) {
        if (arguments == null)
            arguments = [];
        if (typeof Phone !== 'undefined') {
            var json = Phone.sql(query, JSON.stringify(arguments));
            var result = jQuery.parseJSON(json);
            if (result.success == false)
                throw Error (result.exception);
            return new ResultSet(result.data);
        } else {
            var data = $.ajax(
                {
                    dataType: "json",
                    url: "sqlitecom.php",
                    data: {query: query, arg: arguments},
                    async: false
                }
            );
            if (data.status != 200) {
                throw Error("Cannot access url. ReadyState: " + data.readyState + " Status: " + data.status + " Response:" + data.responseText);
            }
            var result = jQuery.parseJSON(data.responseText);
            if (result.success == false) {
                throw Error(result.exception);
            }
            return new ResultSet(result.data);
        }
    };


    /**
     *
     * @param array
     * @constructor
     */
    function ResultSet (resultSet) {
        var mRes = resultSet;
        console.log ("New ResultSet: ", mRes);




        this.numRows = function () {
            return mRes.length;
        };

        this.first = function () {
            return mRes[0];
        };

        this.onHasData = function (cb) {
            if (mRes.length > 0)
                cb();
            return this;
        };

        this.onHasNoData = function (cb) {
            if (mRes.length == 0)
                cb();
            return this;
        };

        this.one = function () {
            return mRes[0];
        };

        this.each = function (cb) {
            var index = 0;
            for (index = 0; index<mRes.length; index++) {
                cb(mRes[index], index);
            }
        }


    }
//}



