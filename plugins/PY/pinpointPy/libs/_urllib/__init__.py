#!/usr/bin/env python
# -*- coding: UTF-8 -*-

# ------------------------------------------------------------------------------
#  Copyright  2020. NAVER Corp.                                                -
#                                                                              -
#  Licensed under the Apache License, Version 2.0 (the "License");             -
#  you may not use this file except in compliance with the License.            -
#  You may obtain a copy of the License at                                     -
#                                                                              -
#   http://www.apache.org/licenses/LICENSE-2.0                                 -
#                                                                              -
#  Unless required by applicable law or agreed to in writing, software         -
#  distributed under the License is distributed on an "AS IS" BASIS,           -
#  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.    -
#  See the License for the specific language governing permissions and         -
#  limitations under the License.                                              -
# ------------------------------------------------------------------------------

# Created by eeliu at 8/20/20

from pinpointPy.Interceptor import Interceptor, intercept_once
from pinpointPy import get_logger


@intercept_once
def monkey_patch():
    try:
        from urllib.request import Request
        from urllib import request
        from .RequestPlugin import RequestPlugin
        from .UrlOpenPlugin import UrlOpenPlugin

        Interceptors = [
            Interceptor(Request, '__init__', RequestPlugin),
            Interceptor(request, 'urlopen', UrlOpenPlugin)
        ]

        for interceptor in Interceptors:
            interceptor.enable()
    except ImportError as e:
        get_logger().info(f"exception at {e}")
        import sys
        if 'unittest' in sys.modules.keys():
            raise e


__all__ = ['monkey_patch']

__version__ = '0.0.6'
__author__ = 'liu.mingyi@navercorp.com'

# changes
# 0.0.6
# - fix https://github.com/pinpoint-apm/pinpoint-c-agent/issues/626
