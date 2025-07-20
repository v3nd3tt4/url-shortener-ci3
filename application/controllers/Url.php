<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Url extends CI_Controller {
    public function __construct() {
        parent::__construct();
        // Hanya dashboard yang butuh login
        if ($this->router->method === 'dashboard' && !$this->session->userdata('admin_logged_in')) {
            redirect('welcome/index');
        }
    }

    public function dashboard() {
        $admin = $this->session->userdata('admin_username');
        $this->load->view('dashboard', ['admin' => $admin]);
    }

    public function shorten() {
        if ($this->input->post()) {
            
            $original_url = $this->input->post('original_url');
            $custom_url = trim($this->input->post('custom_url'));
            $title = trim($this->input->post('title'));
            $description = trim($this->input->post('description'));
            $expired_at = $this->input->post('expired_at');
            
            // Validasi URL
            if (!filter_var($original_url, FILTER_VALIDATE_URL)) {
                echo json_encode(['status' => 'error', 'message' => 'URL tidak valid! Pastikan URL dimulai dengan http:// atau https://']);
                return;
            }
            
            // Bersihkan custom URL dari spasi dan karakter khusus
            if ($custom_url) {
                $custom_url = preg_replace('/[^a-zA-Z0-9\-_]/', '', $custom_url);
                if (empty($custom_url)) {
                    echo json_encode(['status' => 'error', 'message' => 'Custom URL hanya boleh berisi huruf, angka, tanda hubung (-), dan underscore (_)!']);
                    return;
                }
            }
            
            // expired otomatis 30 hari jika kosong
            if (empty($expired_at)) {
                $expired_at = date('Y-m-d H:i:s', strtotime('+30 days'));
            }
            $short_code = $custom_url ?: substr(md5(uniqid()), 0, 6);

            // Cek duplikasi
            if ($this->db->get_where('urls', ['short_code' => $short_code])->row()) {
                echo json_encode(['status' => 'error', 'message' => 'Custom URL sudah digunakan!']);
                return;
            }

            $data = [
                'original_url' => $original_url,
                'short_code' => $short_code,
                'custom_url' => $custom_url ?: null,
                'title' => $title ?: null,
                'description' => $description ?: null,
                'expired_at' => $expired_at,
                'created_at' => date('Y-m-d H:i:s'),
                'ip_address' => $this->input->ip_address(),
                'user_agent' => $this->input->user_agent()
            ];
            $this->db->insert('urls', $data);
            echo json_encode(['status' => 'success', 'short_url' => base_url($short_code)]);
        } else {
            $this->load->view('shorten_form');
        }
    }

    public function edit($id = null) {
        $is_ajax = $this->input->is_ajax_request();
        if (!$this->session->userdata('admin_logged_in')) {
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => 'Session Anda telah habis. Silakan login ulang.']);
                return;
            } else {
                redirect('welcome/index');
            }
        }

        if ($this->input->post()) {
            $original_url = $this->input->post('original_url');
            $custom_url = trim($this->input->post('custom_url'));
            $title = trim($this->input->post('title'));
            $description = trim($this->input->post('description'));
            $expired_at = $this->input->post('expired_at');
            $is_active = $this->input->post('is_active') ? 1 : 0;

            // Validasi URL
            if (!filter_var($original_url, FILTER_VALIDATE_URL)) {
                echo json_encode(['status' => 'error', 'message' => 'URL tidak valid! Pastikan URL dimulai dengan http:// atau https://']);
                return;
            }

            // Bersihkan custom URL dari spasi dan karakter khusus
            if ($custom_url) {
                $custom_url = preg_replace('/[^a-zA-Z0-9\-_]/', '', $custom_url);
                if (empty($custom_url)) {
                    echo json_encode(['status' => 'error', 'message' => 'Custom URL hanya boleh berisi huruf, angka, tanda hubung (-), dan underscore (_)!']);
                    return;
                }
            }

            // Jika custom_url diisi, update short_code juga
            if ($custom_url) {
                // Cek duplikasi custom_url kecuali untuk URL yang sedang diedit
                $existing = $this->db->get_where('urls', ['short_code' => $custom_url, 'id !=' => $id])->row();
                if ($existing) {
                    echo json_encode(['status' => 'error', 'message' => 'Custom URL sudah digunakan!']);
                    return;
                }
                
                $data = [
                    'original_url' => $original_url,
                    'short_code' => $custom_url,
                    'custom_url' => $custom_url,
                    'title' => $title ?: null,
                    'description' => $description ?: null,
                    'expired_at' => $expired_at,
                    'is_active' => $is_active,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            } else {
                $data = [
                    'original_url' => $original_url,
                    'custom_url' => null,
                    'title' => $title ?: null,
                    'description' => $description ?: null,
                    'expired_at' => $expired_at,
                    'is_active' => $is_active,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
            
            $this->db->where('id', $id)->update('urls', $data);
            echo json_encode(['status' => 'success', 'message' => 'URL berhasil diperbarui!']);
        } else {
            $url = $this->db->get_where('urls', ['id' => $id])->row();
            if (!$url) {
                show_404();
            }
            $this->load->view('edit_url', ['url' => $url]);
        }
    }

    public function delete($id = null) {
        $is_ajax = $this->input->is_ajax_request();
        if (!$this->session->userdata('admin_logged_in')) {
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => 'Session Anda telah habis. Silakan login ulang.']);
                return;
            } else {
                redirect('welcome/index');
            }
        }

        $url = $this->db->get_where('urls', ['id' => $id])->row();
        if (!$url) {
            echo json_encode(['status' => 'error', 'message' => 'URL tidak ditemukan!']);
            return;
        }

        $this->db->where('id', $id)->delete('urls');
        echo json_encode(['status' => 'success', 'message' => 'URL berhasil dihapus!']);
    }

    public function redirect($code) {
        $url = $this->db->get_where('urls', ['short_code' => $code])->row();
        
        if (!$url) {
            $this->load->view('errors/html/error_404');
            return;
        }
        
        if ($url->is_active == 0) {
            $this->load->view('errors/html/error_general', [
                'message' => 'URL ini telah dinonaktifkan oleh administrator.'
            ]);
            return;
        }
        
        if ($url->expired_at && strtotime($url->expired_at) < time()) {
            $this->load->view('errors/html/error_general', [
                'message' => 'URL ini telah kadaluarsa pada ' . date('d/m/Y H:i', strtotime($url->expired_at)) . '.'
            ]);
            return;
        }
        
        // URL valid, lakukan redirect
        $this->db->set('clicks', 'clicks+1', FALSE)->where('id', $url->id)->update('urls');
        $this->db->insert('click_logs', [
            'url_id' => $url->id,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'referer' => $this->input->server('HTTP_REFERER'),
            'country' => null,
            'city' => null
        ]);
        redirect($url->original_url);
    }

    public function get_url_info($id) {
        $is_ajax = $this->input->is_ajax_request();
        if (!$this->session->userdata('admin_logged_in')) {
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => 'Session Anda telah habis. Silakan login ulang.']);
                return;
            } else {
                redirect('welcome/index');
            }
        }

        $url = $this->db->get_where('urls', ['id' => $id])->row();
        if ($url) {
            // Format expired_at untuk datetime-local input
            $expired_at_formatted = null;
            if ($url->expired_at) {
                $expired_at_formatted = date('Y-m-d\TH:i', strtotime($url->expired_at));
            }
            
            echo json_encode([
                'status' => 'success',
                'data' => [
                    'original_url' => $url->original_url,
                    'short_code' => $url->short_code,
                    'title' => $url->title,
                    'description' => $url->description,
                    'clicks' => $url->clicks,
                    'is_active' => $url->is_active,
                    'created_at' => $url->created_at,
                    'expired_at' => $expired_at_formatted
                ]
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'URL tidak ditemukan!']);
        }
    }

    public function get_urls_data() {
        if (!$this->session->userdata('admin_logged_in')) {
            echo json_encode(['status' => 'error', 'message' => 'Akses ditolak!']);
            return;
        }

        // DataTable server-side parameters
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $search = $this->input->post('search')['value'];
        $order_column = $this->input->post('order')[0]['column'];
        $order_dir = $this->input->post('order')[0]['dir'];

        // Column mapping
        $columns = ['short_code', 'original_url', 'title', 'clicks', 'is_active', 'created_at', 'expired_at', 'id'];
        $order_by = $columns[$order_column] ?? 'created_at';

        // Build query
        $this->db->select('*');
        $this->db->from('urls');

        // Search functionality
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('short_code', $search);
            $this->db->or_like('original_url', $search);
            $this->db->or_like('title', $search);
            $this->db->or_like('description', $search);
            $this->db->group_end();
        }

        // Get total records before filtering
        $total_records = $this->db->count_all_results('', FALSE);

        // Order and limit
        $this->db->order_by($order_by, $order_dir);
        $this->db->limit($length, $start);

        // Get filtered data
        $urls = $this->db->get()->result();

        // Prepare data for DataTable
        $data = [];
        foreach ($urls as $url) {
            $status = 'active';
            $statusText = 'Aktif';
            if ($url->is_active == 0) {
                $status = 'inactive';
                $statusText = 'Nonaktif';
            } elseif ($url->expired_at && strtotime($url->expired_at) < time()) {
                $status = 'expired';
                $statusText = 'Expired';
            }

            $data[] = [
                // Short URL
                '<div class="d-flex align-items-center">
                    <a href="' . base_url($url->short_code) . '" target="_blank" class="url-link me-2">' . base_url($url->short_code) . '</a>
                    <button class="btn btn-sm btn-outline-secondary" onclick="copyUrl(\'' . base_url($url->short_code) . '\')" title="Salin URL">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>',
                // Original URL
                '<div class="original-url" title="' . $url->original_url . '">' . $url->original_url . '</div>',
                // Title
                $url->title ?: '-',
                // Clicks
                '<span class="badge bg-primary">' . $url->clicks . '</span>',
                // Status
                '<span class="url-status status-' . $status . '">' . $statusText . '</span>',
                // Created
                date('d/m/Y H:i', strtotime($url->created_at)),
                // Expired
                $url->expired_at ? date('d/m/Y H:i', strtotime($url->expired_at)) : 'Tidak ada',
                // Actions
                '<div class="btn-group btn-group-sm">
                    <button class="btn btn-warning" onclick="editUrl(' . $url->id . ')">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger" onclick="deleteUrl(' . $url->id . ')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>'
            ];
        }

        // Get total records after filtering
        $filtered_records = $this->db->count_all_results('', FALSE);

        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => $total_records,
            'recordsFiltered' => $filtered_records,
            'data' => $data
        ]);
    }

    public function get_stats() {
        if (!$this->session->userdata('admin_logged_in')) {
            echo json_encode(['status' => 'error', 'message' => 'Akses ditolak!']);
            return;
        }

        // Get total URLs
        $total_urls = $this->db->count_all('urls');
        
        // Get total clicks
        $total_clicks = $this->db->select_sum('clicks')->get('urls')->row()->clicks ?: 0;
        
        // Get active URLs
        $active_urls = $this->db->where('is_active', 1)->count_all_results('urls');
        
        // Get inactive URLs
        $inactive_urls = $this->db->where('is_active', 0)->count_all_results('urls');

        echo json_encode([
            'status' => 'success',
            'data' => [
                'total_urls' => $total_urls,
                'total_clicks' => $total_clicks,
                'active_urls' => $active_urls,
                'inactive_urls' => $inactive_urls
            ]
        ]);
    }
}