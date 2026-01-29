import 'package:flutter/material.dart';
import '../services/api_service.dart';

class TrainingProvider with ChangeNotifier {
  final ApiService _apiService = ApiService();
  bool _isLoading = false;
  List<dynamic> _trainingSessions = [];
  List<dynamic> _sessionSchedules = [];

  bool get isLoading => _isLoading;
  List<dynamic> get trainingSessions => _trainingSessions;
  List<dynamic> get sessionSchedules => _sessionSchedules;

  Future<void> loadTrainingSessions() async {
    _isLoading = true;
    notifyListeners();

    try {
      _trainingSessions = await _apiService.getTrainingSessions();
    } catch (e) {
      // Handle error
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<void> loadSessionSchedules() async {
    _isLoading = true;
    notifyListeners();

    try {
      _sessionSchedules = await _apiService.getSessionSchedules();
    } catch (e) {
      // Handle error
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }
}
