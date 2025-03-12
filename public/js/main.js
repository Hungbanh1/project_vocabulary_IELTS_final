var config = document.getElementById("config");

var route_search = document.getElementsByClassName("route_search");

var defaultUrl = config.dataset.defaultUrl;
var lastUrl = config.dataset.lastUrl;
var fullUrl = config.dataset.fullUrl;
var route_add = config.dataset.routeAdd;
var route_add_parapharse = config.dataset.routeAddParapharse;
var route_edit_list_parapharse = config.dataset.routeEditListParapharse;


var is_parapharse = config.dataset.isParapharse;
var route_search = route_search[0].dataset.routeSearch;
let isLastPage = false; 
// console.log(defaultUrl);
let isLoading = false;

var page = 1;
var lastKeyword = "";
var isSearching = false;
var canLoadMore;
var totalRecords = 0;

$('.btn-add-vocabulary').click(function(e) {
    e.preventDefault(); // Ngăn form submit
    $('.content').addClass("loading");
    $(".form-control").removeClass("is-invalid"); // Xóa class lỗi
    $(".invalid-feedback").text(""); // Xóa thông báo lỗi cũ
    // const year = $("#select_year").val();
    const english = $("#english").val();
    const vietnam = $("#vietnam").val();
    const type_vocabulary  = $("#type_vocabulary").val();
    // console.log(defaultUrl);
    // console.log("dayladas...");
    
    if(is_parapharse == "parapharse" || type_vocabulary == 6){
        var new_is_parapharse = 1
    }else{
        var new_is_parapharse = 0
    }
    data = {
        english: english,
        vietnam: vietnam,
        type_vocabulary : type_vocabulary ,
        is_parapharse: Number(new_is_parapharse),
    }
    // console.log("Dữ liệu gửi:", data); // Kiểm tra dữ liệu trước khi gửi
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route_add,
        type: "POST",
        data: data,
        success: function(response) {
            $('.content').append(response);
            setTimeout(function() {
                $(".content").removeClass("loading");
                Swal.fire({
                    title: "Thành công!",
                    text: "Thêm từ vựng thành côngdada!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() =>{
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 200);
                });
            }, 500);
        },
        error: function(xhr) {
            // $(".content").removeClass("loading");
            setTimeout(function() {
                $(".content").removeClass("loading");
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    // console.log(errors);
                    
                    // Duyệt qua từng lỗi và hiển thị dưới input
                    Object.keys(errors).forEach(function(key) {
                        // console.log(key);
                        
                        $("#" + key).addClass(
                            "is-invalid"); // Thêm class đỏ vào input
                        $("#" + key + "-error").text(errors[key][
                            0
                        ]); // Hiển thị lỗi
                    });
                } else {
                    Swal.fire("Lỗi!", "Có lỗi xảy ra. Vui lòng thử lại!", "error");
                }
            }, 500);
        },
        complete: function() {
        },

    })

})
$('.btn-add-parapharse').click(function(e) {
    e.preventDefault(); // Ngăn form submit
    $('.content').addClass("loading");
    $(".form-control").removeClass("is-invalid"); // Xóa class lỗi
    $(".invalid-feedback").text(""); // Xóa thông báo lỗi cũ
    // const year = $("#select_year").val();
    const english = $("#english").val();
    const vietnam = $("#vietnam").val();
    // console.log(route_add_parapharse);
    
    data = {
        english: english,
        vietnam: vietnam,
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route_add_parapharse,
        type: "POST",
        data: data,
        success: function(response) {
            // console.log(response);
            
            $('.content').html(response);
            setTimeout(function() {
                $(".content").removeClass("loading");
                Swal.fire({
                    title: "Thành công!",
                    text: "Thêm từ vựng thành công!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() =>{
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 200);
                });
            }, 500);
        },
        error: function(xhr) {
            // $(".content").removeClass("loading");
            setTimeout(function() {
                $(".content").removeClass("loading");
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    // console.log(errors);
                    
                    // Duyệt qua từng lỗi và hiển thị dưới input
                    Object.keys(errors).forEach(function(key) {
                        // console.log(key);
                        
                        $("#" + key).addClass(
                            "is-invalid"); // Thêm class đỏ vào input
                        $("#" + key + "-error").text(errors[key][
                            0
                        ]); // Hiển thị lỗi
                    });
                } else {
                    Swal.fire("Lỗi!", "Có lỗi xảy ra. Vui lòng thử lại!", "error");
                }
            }, 500);
        },
        complete: function() {
        },

    })

})


$('.btn-search').click(function(e) {
    e.preventDefault(); // Ngăn form submit
    $('.content').addClass("loading");
    $(".form-control").removeClass("is-invalid"); // Xóa class lỗi
    $(".invalid-feedback").text(""); // Xóa thông báo lỗi cũ
    const keyword = $("#keyword").val();
    const url = route_search + "?keyword=" + encodeURIComponent(keyword);
    // console.log(url);

    data = {
        keyword: keyword,
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: "GET",
        data: data,
        success: function(response) {
            
            $('.content').append(response);
            setTimeout(function() {
                if(response.status == false){
                        $(".content").removeClass("loading");
                        Swal.fire("Lỗi!", response.message, "error")
                }
                else{
                    $(".content").removeClass("loading");
                }
            }, 500);
        
        },
        error: function(xhr) {
            $(".content").removeClass("loading");
            Swal.fire("Lỗi!", "khong tim thay", "error");
          
        },
       

    })

})

//delete vocabulary
$(document).on('click', '.btn-delete-vocabulary, .btn-delete-parapharse, .btn-delete-child-parapharse', function() {
    let vocabularyId = $(this).data('id');
    // console.log(vocabularyId);
    let is_child = $(this).data('is-child') || 0;
    
    var url_voca =  defaultUrl + "/delete/" + vocabularyId ;
    var url_para =  defaultUrl + "/parapharse/delete/" + vocabularyId ;
    var url_child =  defaultUrl + "/parapharse/delete/child/" + vocabularyId ;
    var url_check  = is_parapharse == "parapharse"
        ? url_para
        : url_voca;

    var url = is_child == 1 ? url_child : url_check;
        
    Swal.fire({
        title: "Xác nhận xóa?",
        text: "Bạn có chắc chắn muốn xóa từ vựng này không?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: url,
                data: {
                    id: vocabularyId
                },
                success: function(response) {
                    Swal.fire({
                        title: "Đã xóa!",
                        text: response.message,
                        icon: "success",
                        timer: 1000, 
                        showConfirmButton: false
                    }).then(() => {
                        setTimeout(() => {
                            window.location.href = response.redirect_url;
                            
                        }, 200);
                    });
                },
                error: function(xhr) {
                    // console.log(xhr);
                    
                    Swal.fire("Lỗi!", "Không thể xóa từ vựng.", xhr.vocabulary);
                }
            });
        }
    });
});
function getParapharses(id) {
    return fetch(defaultUrl + `/api/get-list-parapharse/${id}`)
        .then(response => response.json())
        .then(data => data)
        .catch(error => console.error("Error fetching parapharses:", error));
}
//search vocabulary
$(document).ready(function() {
    var timeout = null;
    var url = defaultUrl + "/search/searchajax/";
    var assetUrl = defaultUrl;

    var getColor = function(type_id) {
        var colors = {
            '1': '#fd7e14', // adv - màu cam
            '2': '#dc3545', // adj - màu đỏ
            '3': '#007bff', // v - màu xanh dương
            '4': '#28a745', // n - màu xanh lá
            '5': '#6c757d' // cụm từ - màu xám
        };
        return colors[type_id] || '#6c757d';
    };

    var getTypeName = function(type_id) {
        var types = {
            '1': 'Adv',
            '2': 'Adj',
            '3': 'V',
            '4': 'N',
            '5': 'Phrase',
            '6': 'Parapharse'
        };
        return types[type_id] || 'Phrase';
    };
    
    var createVocabularyItem = function(index, value) {
        var color = getColor(value.type_id);
        var typeName = getTypeName(value.type_id);
        
        var content = `
             <div class="col-xl-6 col-sm-6 vocabulary-item">
        <ul class="list-unstyled">
           <li class="d-flex align-items-center mb-2">
            <p class="mr-2">${index + 1}/</p>
            <p class="vocabulary-vn mr-2" style="color: ${color};">${value.english}</p>
            <p style="color: ${color};">(${typeName})</p>
            <p class="mx-3">:</p>
            <p class="vocabulary-en" style="color: #6c757d;">${value.vietnam}</p>

            </li>
            <li>
            <div class="d-flex list_action">
                <button style="border:none" data-toggle="modal" data-target="#myModalEdit"
                    data-eng="${value.english}" data-vn="${value.vietnam}"
                    data-type="${value.type_id}" data-id="${value.id}">
                    <img src="${assetUrl}/public/img/edit.png" alt="edit vocabulary"
                        class="action-icon">
                </button>
                <button class="delete-link btn-delete-vocabulary" data-id="${value.id}">
                    <img src="${assetUrl}/public/img/delete.png" alt="" class="action-icon">
                </button>
                <button style="border:none; margin-left:5px" data-toggle="modal"
                    data-target="#ModalParapharse" data-eng="${value.english}"
                    data-vn="${value.vietnam}" data-type="${value.type_id}"
                    data-id="${value.id}">
                    <i class="fa-solid fa-plus" style="color:#44ca44"></i>
                </button>
            </div>
            </li>
                    </ul>
                </div>
            `;
       
        return content;
    };
 
    // var createVocabularyItem1 = async function(index, value) {
    var createVocabularyItem1 = async function(index, value) {
 
        var color = getColor(value.type_id);
        var typeName = getTypeName(value.type_id);
        var parapharses = await getParapharses(value.id);
        // console.log(parapharses);
        var parapharseList = parapharses.map(item => `= ${item.english}`).join("\n");
        
        var content = `
             <div class="col-xl-6 col-sm-6 vocabulary-item">
        <ul class="list-unstyled">
           <li class="d-flex align-items-center mb-2">
            <p class="mr-2">${index + 1}/</p>
            <p class="vocabulary-vn mr-2" style="color: #28a745;">${value.english}</p>
            <p class="vocabulary-vn mr-2" style="color: #28a745;">${parapharseList}</p>
            <p class="vocabulary-en" style="color: #6c757d;">= ${value.vietnam}</p>

            </li>
            <li>
            <div class="d-flex list_action pd-5">
              <button class="btn-show-list-parapharse" style="border:none; margin-left:5px" data-toggle="modal"
                    data-target="#ModalParapharseList" data-eng="${value.english}" data-vn="${value.vietnam}"
                    data-type="${value.type_id}" data-id="${value.id}">
                    <i class="fa-solid fa-list"></i>
                </button>
                <button style="border:none" data-toggle="modal" data-target="#myModalEdit"
                    data-eng="${value.english}" data-vn="${value.vietnam}"
                    data-type="${value.type_id}" data-id="${value.id}">
                    <img src="${assetUrl}/public/img/edit.png" alt="edit vocabulary"
                        class="action-icon">
                </button>
                <button class="delete-link btn-delete-vocabulary" data-id="${value.id}">
                    <img src="${assetUrl}/public/img/delete.png" alt="" class="action-icon">
                </button>
                <button style="border:none; margin-left:5px" data-toggle="modal"
                    data-target="#ModalParapharse" data-eng="${value.english}"
                    data-vn="${value.vietnam}" data-type="${value.type_id}"
                    data-id="${value.id}">
                    <i class="fa-solid fa-plus" style="color:#44ca44"></i>
                </button>
            </div>
            </li>
                    </ul>
                </div>
            `;
       
        return content;
    };
    $('.keyword').keyup(function(event) {
        clearTimeout(timeout);
        const keyword = $('.keyword').val().trim();
        // console.log(keyword.length);
        
        // Kiểm tra nếu bấm Backspace và input bị xóa hết thì không gọi API
        // if (event.which === 8) {
        //     return;
        // }
    
        if (keyword !== lastKeyword) {
            lastKeyword = keyword;
            canLoadMore = true; // Reset loadMore
            page = 1; 
            isSearching = keyword !== "";
            $("#main_content").empty();
        }
        data = {
            'keyword': keyword,
        }
        if(keyword.length > 0 || keyword.length == 0){
            timeout = setTimeout(function() {
                var data = {
                    keyword: keyword,
                    lastUrl: lastUrl,
                }; 
                    $.ajax({
                        type: 'get',
                        dataType: 'json',
                        data: data,
                        url: url,
                        success: function(data) {
                            // console.log("data",data);
                            $('#main_content').empty();
                            // console.log(data);
                            // console.log(lastUrl);
                            
                            // var count = data.data.length;
                            var count = data.vocabulary.total;
                            totalRecords = count;
                            
                            // console.log(totalRecords);
                            // console.log(lastUrl);
                            
                            if (count >= 0) {
                                $('.total_vocabulary').html(`
                                    <p>Hiện tại có: <span class="text-danger">${count}</span> từ vựng</p>
                                `);
                            } 
                            //  if (totalRecords < 10) {
                            //     canLoadMore = false;
                            // }
                            if (totalRecords > 0) {
                                if(lastUrl == "parapharse"){
                                    Promise.all(data.vocabulary.data.map(async function(value, index) {
                                        return await createVocabularyItem1(index, value);
                                    })).then(function(contents) {
                                        $('#main_content').html(contents.join(''));
                                    });
                                }
                                else{
                                    var content = data.vocabulary.data.map(function(value,
                                        index) {
                                        return createVocabularyItem(index, value);
                                    }).join('');
                                    $('#main_content').html(content);
                                }
                               
                            } 
                            
                            else {
                                $('#main_content').html(`
                        <div class="col-12">
                            <div class="alert alert-warning" role="alert">
                                Không có từ vựng
                            </div>
                        </div>
                    `);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            console.error('Lỗi AJAX:', xhr.status, thrownError);
                        },
                    });
                }, 200);
        }
       
    });
});
$(window).scroll(function() {
    if (isLoading || isLastPage) return;

    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
        isLoading = true; // Đánh dấu là đang tải dữ liệu
        page++; 
        infiniteLoadMore(page);
    }
});

function infiniteLoadMore(page) {
    $('.content').addClass("loading");
    
    $.ajax({
        url: fullUrl + "?page=" + page,
        data: {
            keyword: isSearching ? lastKeyword : "",
        },
        type: "GET",
        success: function(data) {
            //check data before check trim
            if (!data.html || !data.html.trim()) {
                $(".content").removeClass("loading");
                isLastPage = true; 
                return;
            }
            setTimeout(function() {
                $(".content").removeClass("loading");
                $("#main_content").append(data.html);
                isLoading = false; // Đánh dấu đã load xong
            }, 1000);
        },
        error: function() {
            isLoading = false; // Nếu có lỗi cũng phải reset trạng thái
        }
    });
}

    
$(document).on('click', '.btn-show-list-parapharse', function() {
    let id = $(this).data('id');
    var url = defaultUrl + "/api/get-list-parapharse/" + id;
    console.log(url);
    
    var t = 0;
    $(".form-control").removeClass("is-invalid"); // Xóa class lỗi
    $(".invalid-feedback").remove(); // Xóa thông báo lỗi cũ
    data = {
        'id' : id,
    }
 
    $.ajax({
        url: url, 
        data: data,
        type: 'GET',
        success: function(data) {
            $('#parapharseList').empty();

            $(".content").addClass("loading");
                
           if(data.length > 0){
                    $(".content").removeClass("loading");
                    data.forEach(function(item, index) {
                    t++;
                    $('#parapharseList').append(`
                        <div class="col-sm-12 col-xl-12 text-danger">
                            <h5 class="badge badge-info">Paraphase ${t}</h5>
                              <button class="delete-link btn-delete-child-parapharse bg-none" data-is-child= 1 data-id="${item.id}">
                                <img src="${defaultUrl+"/public/img/delete.png"}" alt="" class="action-icon">
                            </button>
                        </div>
                        
                        <input class="id_list_para" id="${item.id}" type="hidden" name="parapharse[${index}][id]" value="${item.id}">
                        <div class="form-group col-sm-6 col-xl-6">
                            <label for="eng_${index}">Tiếng Anh <strong class="text-danger">*</strong></label>
                            <input type="text" class="form-control" name="parapharse[${index}][eng]"
                                value="${item.english}" id="eng_${index}" placeholder="Nhập từ tiếng Anh" data-id="${item.id}">
                            <span class="invalid-feedback" data-name="parapharse[${index}][eng]-error"></span>
                        </div>
                        <div class="form-group col-sm-6 col-xl-6">
                            <label for="vn_${index}">Tiếng Việt <strong class="text-danger">*</strong></label>
                            <input type="text" class="form-control" name="parapharse[${index}][vn]"
                                value="${item.vietnam}" id="vn_${index}" placeholder="Nhập từ tiếng Việt" data-id="${item.id}">
                        <span class="invalid-feedback" data-name="parapharse[${index}][vn]-error"></span>
                        </div>
                    `);
                });
           }else{
                $(".content").removeClass("loading");
                $('#parapharseList').append(`<p class="text-danger col-sm-12 col-xl-12">Không có dữ liệu</p>`)
           }
        },
        error: function(xhr) {

            if (xhr.status === 422) { // Lỗi validation
                let errors = xhr.responseJSON.errors;
                // console.log(errors);
                
                // Reset lỗi cũ
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text("");
    
                // Duyệt qua lỗi và thêm vào input tương ứng
                Object.keys(errors).forEach(function(key) {
                    // console.log(key);
                    
                    $("#" + key).addClass(
                        "is-invalid"); // Thêm class đỏ vào input
                    $("#" + key + "-error").text(errors[key][
                        0
                    ]); // Hiển thị lỗi
                });
            } else {
                alert("Lỗi không xác định xảy ra!");
            }
        }
    });
});

$('.btn-edit-list-parapharse').click(function(e) {
    e.preventDefault(); // Ngăn form submit
    $('.content').addClass("loading");
    $(".form-control").removeClass("is-invalid"); // Xóa class lỗi
    $(".invalid-feedback").text(""); // Xóa thông báo lỗi cũ
    
    var parapharse = [];

    let inputsEng = document.querySelectorAll('input[name^="parapharse"][name$="[eng]"]');
    let inputsVn = document.querySelectorAll('input[name^="parapharse"][name$="[vn]"]');
    let id_parapharse =  $("#id_parapharse").val(); // Lấy ID từ data-id hoặc input ẩn
    // console.log(id_parapharse);
    
    inputsEng.forEach((input, index) => {
        parapharse.push({
            id: input.dataset.id, // Thêm ID vào object
            eng: input.value, 
            vn: inputsVn[index] ? inputsVn[index].value : ''
        });
    });
    data = {
        id_parapharse:id_parapharse,
        parapharse: parapharse,
    }
    // console.log("dữ liệu gửi", data);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route_edit_list_parapharse,
        type: "POST",
        data: data,
        success: function(response) {
            // console.log("dữ liệu nhận", response);
            if (response.not_update) {
                $(".content").removeClass("loading");
                Swal.fire({
                    title: "Thông báo!",
                    text: response.message,
                    icon: "info",
                    confirmButtonText: "OK"
                });
                return; 
            }else{
                if(response.parapharse){
                    $('.content').append(response);
                    setTimeout(function() {
                        $(".content").removeClass("loading");
                        Swal.fire({
                            title: "Thành công!",
                            text: "Cập nhật thành công",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() =>{
                            setTimeout(() => {
                                window.location.href = response.redirect_url;
                            }, 200);
                        });
                    }, 500);
                }
            }        
        },
        error: function(xhr) {
            setTimeout(function() {
                $(".content").removeClass("loading");
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    // console.log(errors);
                    // Duyệt qua từng lỗi và hiển thị dưới input
                    Object.keys(errors).forEach(function(key) {
                        let formattedKey = key.replace(/\.(\d+)\./g, '[$1]['); // Đổi 'parapharse.0.eng' → 'parapharse[0][eng]'

                        formattedKey = formattedKey.replace(/\./g, '][') + ']';
                        
                        let selector = "[name='" + formattedKey + "']";
                        $(selector).addClass("is-invalid"); 
                        $("[data-name='" + formattedKey + "-error']").text(errors[key][0]);
                        // console.log("[data-name='" + formattedKey + "-error']");
                        
                    
                    });
                } else {
                    Swal.fire("Lỗi!", "Có lỗi xảy ra. Vui lòng thử lại!", "error");
                }
            }, 500);
        },
      

    })

})
